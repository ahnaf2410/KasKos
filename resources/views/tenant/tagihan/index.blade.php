@extends('layouts.tenant', ['activePage' => 'tagihan'])

@section('content')
<div x-data="{
    activeTab: 'semua',
    openPaymentModal: false,
    openDetailModal: false,
    selectedBill: { id: '', title: '', amount: '', period: '', status: '' },
    triggerPayment(id, title, amount, period) {
        this.selectedBill = { id, title, amount, period, status: 'Belum Dibayar' };
        this.openPaymentModal = true;
    },
    triggerDetail(title, amount, period, status, dateInfo) {
        this.selectedBill = { id: '', title, amount, period, status, dateInfo };
        this.openDetailModal = true;
    }
}" class="space-y-6">

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Tagihan Saya</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola dan selesaikan pembayaran bulanan Anda.</p>
    </div>

    <div class="flex flex-wrap gap-2 mb-6">
        <button @click="activeTab = 'semua'" :class="activeTab === 'semua' ? 'bg-[#bd2537] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-1.5 text-xs font-semibold rounded-full transition duration-200">Semua</button>
        <button @click="activeTab = 'belum_dibayar'" :class="activeTab === 'belum_dibayar' ? 'bg-[#bd2537] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-1.5 text-xs font-semibold rounded-full transition duration-200">Belum Dibayar</button>
        <button @click="activeTab = 'menunggu_verifikasi'" :class="activeTab === 'menunggu_verifikasi' ? 'bg-[#bd2537] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-1.5 text-xs font-semibold rounded-full transition duration-200">Menunggu Verifikasi</button>
        <button @click="activeTab = 'lunas'" :class="activeTab === 'lunas' ? 'bg-[#bd2537] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-1.5 text-xs font-semibold rounded-full transition duration-200">Lunas</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($tagihans as $tagihan)
        @php
            // 1. Amankan teks string menggunakan addslashes agar tanda petik (') tidak merusak Javascript
            $namaTagihan   = addslashes($tagihan->nama_tagihan);
            $nominalFormat = 'Rp ' . number_format($tagihan->total_tagihan, 0, ',', '.');
            $keterangan    = addslashes($tagihan->keterangan ?? '-');

            // 2. Logika penentuan teks status untuk modal
            $statusText = 'Belum Dibayar';
            if ($tagihan->status === 'lunas') {
                $statusText = 'Lunas';
            } elseif ($tagihan->status === 'menunggu_verifikasi') {
                $statusText = 'Menunggu Verifikasi';
            }

            // 3. Pengaman objek tanggal dari null pointer exception
            $tanggalText = '-';
            if ($tagihan->status === 'lunas' && $tagihan->tanggal_verifikasi) {
                $tanggalText = is_string($tagihan->tanggal_verifikasi)
                    ? date('d M Y', strtotime($tagihan->tanggal_verifikasi))
                    : $tagihan->tanggal_verifikasi->format('d M Y');
            } elseif ($tagihan->tanggal_bayar) {
                $tanggalText = is_string($tagihan->tanggal_bayar)
                    ? date('d M Y', strtotime($tagihan->tanggal_bayar))
                    : $tagihan->tanggal_bayar->format('d M Y');
            }
        @endphp

        <div x-show="activeTab === 'semua' || activeTab === '{{ $tagihan->status }}'"
             x-transition
             class="bg-white rounded-2xl border border-slate-100 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition duration-200">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                        {{ $tagihan->kategori == 'sewa' || $tagihan->kategori == 'internet' ? 'bg-rose-50 text-[#bd2537]' : '' }}
                        {{ $tagihan->kategori == 'listrik' ? 'bg-amber-50 text-amber-500' : '' }}
                        {{ $tagihan->kategori == 'air' ? 'bg-emerald-50 text-emerald-500' : '' }}">

                        @if($tagihan->kategori == 'sewa')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        @elseif($tagihan->kategori == 'listrik')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                        @elseif($tagihan->kategori == 'air')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.05 3.636a1 1 0 011.414 0 10 10 0 010 14.14 1 1 0 01-1.414 0 10 10 0 010-14.14zm13.9 0a1 1 0 010 1.414 10 10 0 010 14.14 1 1 0 01-1.414 0 10 10 0 010-14.14zM7.879 6.464a1 1 0 011.415 0 6 6 0 010 8.486 1 1 0 01-1.415 0 6 6 0 010-8.486zm8.242 0a1 1 0 010 1.415 6 6 0 010 8.486 1 1 0 01-1.414 0 6 6 0 010-8.486zM11 9a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                        @endif
                    </div>

                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded tracking-wider
                        {{ $tagihan->status == 'belum_dibayar' ? 'bg-red-50 text-red-600' : '' }}
                        {{ $tagihan->status == 'menunggu_verifikasi' ? 'bg-amber-50 text-amber-600' : '' }}
                        {{ $tagihan->status == 'lunas' ? 'bg-emerald-50 text-emerald-600' : '' }}">
                        {{ str_replace('_', ' ', $tagihan->status) }}
                    </span>
                </div>

                <h3 class="text-lg font-bold text-slate-800">{{ $tagihan->nama_tagihan }}</h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ $tagihan->keterangan }}</p>

                <div class="mt-5">
                    <span class="text-[10px] font-bold text-slate-400 block tracking-wider uppercase">Total Tagihan</span>
                    <span class="text-2xl font-black text-slate-900 block mt-0.5">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-6">
                <div class="flex items-center space-x-1.5 text-xs text-slate-500 mb-3">
                    @if($tagihan->status == 'belum_dibayar')
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Jatuh tempo: <strong class="text-slate-700">{{ $tagihan->jatuh_tempo ? (is_string($tagihan->jatuh_tempo) ? date('d M Y', strtotime($tagihan->jatuh_tempo)) : $tagihan->jatuh_tempo->format('d M Y')) : '-' }}</strong></span>
                    @elseif($tagihan->status == 'menunggu_verifikasi')
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Dibayar pada: <strong class="text-slate-700">{{ $tagihan->tanggal_bayar ? (is_string($tagihan->tanggal_bayar) ? date('d M Y', strtotime($tagihan->tanggal_bayar)) : $tagihan->tanggal_bayar->format('d M Y')) : '-' }}</strong></span>
                    @else
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Terverifikasi: <strong class="text-slate-700">{{ $tagihan->tanggal_verifikasi ? (is_string($tagihan->tanggal_verifikasi) ? date('d M Y', strtotime($tagihan->tanggal_verifikasi)) : $tagihan->tanggal_verifikasi->format('d M Y')) : '-' }}</strong></span>
                    @endif
                </div>

                @if($tagihan->status == 'belum_dibayar')
                    <button @click="triggerPayment('{{ $tagihan->id }}', '{{ $namaTagihan }}', '{{ $nominalFormat }}', '{{ $keterangan }}')"
                            class="w-full py-2.5 bg-[#bd2537] text-white text-sm font-semibold rounded-xl hover:bg-rose-700 transition duration-200">
                        Bayar Sekarang
                    </button>
                @else
                    <button @click="triggerDetail('{{ $namaTagihan }}', '{{ $nominalFormat }}', '{{ $keterangan }}', '{{ $statusText }}', '{{ $tanggalText }}')"
                            class="w-full py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition duration-200">
                        Lihat Detail
                    </button>
                @endif
            </div>
        </div>
        @endforeach

        <div class="bg-gradient-to-br from-[#1e222b] to-[#111317] rounded-2xl p-6 text-white flex flex-col justify-between shadow-lg md:col-span-2 relative overflow-hidden">
            <div class="absolute right-0 bottom-0 translate-x-4 translate-y-4 text-slate-700/10 pointer-events-none">
                <svg class="w-40 h-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <div class="relative z-10">
                <h3 class="text-xl font-bold tracking-tight">Ringkasan Tagihan</h3>
                <p class="text-sm text-slate-400 mt-3 leading-relaxed max-w-xl">
                    Anda memiliki <span class="text-rose-400 font-semibold">{{ $totalTertundaCount }} tagihan tertunda</span> dengan total <span class="font-bold text-white">Rp {{ number_format($totalTertundaNominal, 0, ',', '.') }}</span>. Bayar sebelum jatuh tempo untuk menghindari denda.
                </p>
            </div>
            <div class="flex flex-wrap gap-4 mt-8 relative z-10">
                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/40 rounded-xl px-4 py-2.5 flex-1 min-w-[140px]">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Terbayar</span>
                    <span class="text-base font-bold text-slate-200 mt-0.5 block">Rp {{ number_format($totalTerbayarNominal, 0, ',', '.') }}</span>
                </div>
                <div class="bg-rose-950/40 backdrop-blur-sm border border-rose-900/40 rounded-xl px-4 py-2.5 flex-1 min-w-[140px]">
                    <span class="text-[10px] font-bold text-rose-300 uppercase tracking-wider block">Sisa</span>
                    <span class="text-base font-bold text-rose-400 mt-0.5 block">Rp {{ number_format($totalTertundaNominal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>

    <div x-show="openPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" x-cloak>
        <div @click="openPaymentModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6 border border-slate-100 transform transition-all">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-lg font-bold text-slate-900">Konfirmasi Pembayaran</h3>
                <button type="button" @click="openPaymentModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="'/resident/tagihan/' + selectedBill.id + '/bayar'" method="POST" class="py-4 space-y-3">
                @csrf
                <p class="text-sm text-slate-600">Anda akan melakukan pembayaran untuk layanan berikut:</p>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-1.5">
                    <p class="text-xs text-slate-400 font-medium">Nama Tagihan</p>
                    <p class="text-sm font-bold text-slate-800" x-text="selectedBill.title"></p>
                    <hr class="border-slate-200/60 my-1">
                    <p class="text-xs text-slate-400 font-medium">Jumlah Pembayaran</p>
                    <p class="text-lg font-black text-[#bd2537]" x-text="selectedBill.amount"></p>
                </div>

                <div class="flex space-x-3 mt-4">
                    <button type="button" @click="openPaymentModal = false" class="flex-1 py-2 text-sm font-medium border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="flex-1 py-2 text-sm font-semibold bg-[#bd2537] text-white rounded-xl hover:bg-rose-700 shadow-md">Proses Bayar</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" x-cloak>
        <div @click="openDetailModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6 border border-slate-100 transform transition-all">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-lg font-bold text-slate-900">Detail Status Tagihan</h3>
                <button type="button" @click="openDetailModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="py-4 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-base font-bold text-slate-800" x-text="selectedBill.title"></h4>
                        <p class="text-xs text-slate-400 mt-0.5" x-text="selectedBill.period"></p>
                    </div>
                    <span :class="selectedBill.status === 'Lunas' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-amber-50 text-amber-600 border border-amber-200'"
                          class="px-2.5 py-1 text-[10px] font-bold uppercase rounded tracking-wider"
                          x-text="selectedBill.status">
                    </span>
                </div>
                <div class="border border-slate-100 rounded-xl overflow-hidden text-sm">
                    <div class="flex justify-between p-3 bg-slate-50/70 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Tanggal Aksi</span>
                        <span class="font-semibold text-slate-700" x-text="selectedBill.dateInfo"></span>
                    </div>
                    <div class="flex justify-between p-3">
                        <span class="text-slate-400 font-medium">Total Nominal</span>
                        <span class="font-black text-slate-900" x-text="selectedBill.amount"></span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="button" @click="openDetailModal = false" class="px-5 py-2 text-sm font-semibold bg-slate-900 text-white rounded-xl hover:bg-slate-800">Tutup</button>
            </div>
        </div>
    </div>

</div>
@endsection
