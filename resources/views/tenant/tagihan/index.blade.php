@extends('layouts.tenant', ['activePage' => 'pembayaran'])

@section('content')
<div x-data="{
    activeTab: 'semua',
    openPaymentModal: false,
    openDetailModal: false,
    selectedBill: { id: '', title: '', amount: '', period: '', status: '', type: '' },
    triggerPayment(id, title, amount, period, type) {
        this.selectedBill = { id, title, amount, period, status: 'Belum Dibayar', type };
        this.openPaymentModal = true;
    },
    triggerDetail(title, amount, period, status, dateInfo) {
        this.selectedBill = { id: '', title, amount, period, status, dateInfo };
        this.openDetailModal = true;
    }
}" class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Biaya Sewa & Tagihan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola dan selesaikan pembayaran bulanan Anda.</p>
        </div>
    </div>

    {{-- Filter Bulan --}}
    <form method="GET" action="{{ route('tenant.tagihan.index') }}" class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label class="text-xs font-bold text-slate-500 block mb-1">Bulan</label>
                <select name="month" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $bulan)
                        <option value="{{ $i + 1 }}" {{ request('month', now()->format('m')) == ($i + 1) ? 'selected' : '' }}>{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 block mb-1">Tahun</label>
                <select name="year" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                    <option value="">Semua Tahun</option>
                    @for($y = now()->year; $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ request('year', now()->format('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-lg transition">Filter</button>
            <a href="{{ route('tenant.tagihan.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-lg transition">Reset</a>
        </div>
    </form>

    {{-- Tab Filter --}}
    <div class="flex flex-wrap gap-2">
        <button @click="activeTab = 'semua'" :class="activeTab === 'semua' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-1.5 text-xs font-semibold rounded-full transition">Semua</button>
        <button @click="activeTab = 'unpaid'" :class="activeTab === 'unpaid' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-1.5 text-xs font-semibold rounded-full transition">Belum Dibayar</button>
        <button @click="activeTab = 'pending_verification'" :class="activeTab === 'pending_verification' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-1.5 text-xs font-semibold rounded-full transition">Menunggu Verifikasi</button>
        <button @click="activeTab = 'paid'" :class="activeTab === 'paid' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-1.5 text-xs font-semibold rounded-full transition">Lunas</button>
    </div>

    {{-- Tagihan Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($tagihans as $tagihan)
        @php
            $namaTagihan = addslashes($tagihan->nama_tagihan);
            $nominalFormat = 'Rp ' . number_format($tagihan->total_tagihan, 0, ',', '.');
            $keterangan = addslashes($tagihan->keterangan ?? '-');

            $statusText = 'Belum Dibayar';
            if ($tagihan->status === 'paid') $statusText = 'Lunas';
            elseif ($tagihan->status === 'pending_verification') $statusText = 'Menunggu Verifikasi';

            $statusClass = match($tagihan->status) {
                'unpaid' => 'bg-red-50 text-red-600',
                'pending_verification' => 'bg-amber-50 text-amber-600',
                'paid' => 'bg-emerald-50 text-emerald-600',
                default => 'bg-slate-50 text-slate-600',
            };

            $iconBg = match($tagihan->kategori) {
                'sewa' => 'bg-rose-50 text-rose-600',
                'patungan' => 'bg-indigo-50 text-indigo-500',
                default => 'bg-slate-50 text-slate-500',
            };
        @endphp

        <div x-show="activeTab === 'semua' || activeTab === '{{ $tagihan->status }}'"
             x-transition
             class="bg-white rounded-xl border border-slate-100 p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $iconBg }}">
                        @if($tagihan->kategori == 'sewa')
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @endif
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded tracking-wider {{ $statusClass }}">{{ str_replace('_', ' ', $tagihan->status) }}</span>
                </div>

                <h3 class="font-bold text-slate-800">{{ $tagihan->nama_tagihan }}</h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ $tagihan->keterangan }}</p>

                <div class="mt-4">
                    <span class="text-[10px] font-bold text-slate-400 block tracking-wider uppercase">Total Tagihan</span>
                    <span class="text-xl font-bold text-slate-900 block mt-0.5">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-50">
                <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-3">
                    @if($tagihan->status == 'unpaid')
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Jatuh tempo: <strong>{{ $tagihan->jatuh_tempo ? (is_string($tagihan->jatuh_tempo) ? date('d M Y', strtotime($tagihan->jatuh_tempo)) : $tagihan->jatuh_tempo->format('d M Y')) : '-' }}</strong></span>
                    @elseif($tagihan->status == 'pending_verification')
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Dibayar pada: <strong>{{ $tagihan->tanggal_bayar ? (is_string($tagihan->tanggal_bayar) ? date('d M Y', strtotime($tagihan->tanggal_bayar)) : $tagihan->tanggal_bayar->format('d M Y')) : '-' }}</strong></span>
                    @else
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Terverifikasi</span>
                    @endif
                </div>

                @if($tagihan->status == 'unpaid')
                    <button @click="triggerPayment('{{ $tagihan->id }}', '{{ $namaTagihan }}', '{{ $nominalFormat }}', '{{ $keterangan }}', '{{ $tagihan->type }}')"
                            class="w-full py-2.5 bg-rose-600 text-white text-sm font-semibold rounded-lg hover:bg-rose-700 transition shadow-sm">
                        Bayar Sekarang
                    </button>
                @else
                    <button @click="triggerDetail('{{ $namaTagihan }}', '{{ $nominalFormat }}', '{{ $keterangan }}', '{{ $statusText }}', '{{ $tagihan->tanggal_verifikasi ?? $tagihan->tanggal_bayar ?? '-' }}')"
                            class="w-full py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition">
                        Lihat Detail
                    </button>
                @endif
            </div>
        </div>
        @endforeach

        {{-- Summary Card --}}
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-5 text-white flex flex-col justify-between shadow-lg md:col-span-2 relative overflow-hidden">
            <div class="absolute right-0 bottom-0 translate-x-4 translate-y-4 text-white/5 pointer-events-none">
                <svg class="w-40 h-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <div class="relative z-10">
                <h3 class="text-lg font-bold">Ringkasan Tagihan</h3>
                <p class="text-sm text-slate-300 mt-2 max-w-xl">
                    Anda memiliki <span class="text-rose-400 font-semibold">{{ $totalTertundaCount }} tagihan tertunda</span> dengan total <span class="font-bold text-white">Rp {{ number_format($totalTertundaNominal, 0, ',', '.') }}</span>.
                </p>
            </div>
            <div class="flex flex-wrap gap-3 mt-6 relative z-10">
                <div class="bg-slate-700/50 backdrop-blur-sm border border-slate-600/40 rounded-lg px-4 py-2.5 flex-1 min-w-[140px]">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Terbayar</span>
                    <span class="text-sm font-bold text-slate-200 mt-0.5 block">Rp {{ number_format($totalTerbayarNominal, 0, ',', '.') }}</span>
                </div>
                <div class="bg-rose-950/40 backdrop-blur-sm border border-rose-900/40 rounded-lg px-4 py-2.5 flex-1 min-w-[140px]">
                    <span class="text-[10px] font-bold text-rose-300 uppercase tracking-wider block">Sisa</span>
                    <span class="text-sm font-bold text-rose-400 mt-0.5 block">Rp {{ number_format($totalTertundaNominal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Modal --}}
    <div x-show="openPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" x-cloak>
        <div @click="openPaymentModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full p-6 border border-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900">Konfirmasi Pembayaran</h3>
                <button type="button" @click="openPaymentModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form :action="'/tenant/tagihan/' + selectedBill.id + '/bayar'" method="POST" enctype="multipart/form-data" class="py-4 space-y-3">
                @csrf
                <p class="text-sm text-slate-600">Pembayaran untuk:</p>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 space-y-1.5">
                    <p class="text-xs text-slate-400 font-medium">Nama Tagihan</p>
                    <p class="font-bold text-slate-800" x-text="selectedBill.title"></p>
                    <hr class="border-slate-200/60">
                    <p class="text-xs text-slate-400 font-medium">Jumlah</p>
                    <p class="text-lg font-bold text-rose-600" x-text="selectedBill.amount"></p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 space-y-1">
                    <p class="text-xs font-bold text-blue-700">Informasi Pembayaran</p>
                    <p class="text-xs text-blue-600">Transfer ke:</p>
                    <p class="text-sm font-bold text-blue-800">Bank BCA - 1234567890</p>
                    <p class="text-xs text-blue-600">a.n. KasKos Management</p>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 block">Upload Bukti Pembayaran</label>
                    <input type="file" name="payment_slip" accept="image/*" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm">
                    <p class="text-[10px] text-slate-400">Format: JPG/PNG, Max: 2MB</p>
                </div>
                <input type="hidden" name="bank_account" value="BCA - 1234567890">
                <div class="flex gap-3 mt-4">
                    <button type="button" @click="openPaymentModal = false" class="flex-1 py-2 text-sm font-medium border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="flex-1 py-2 text-sm font-semibold bg-rose-600 text-white rounded-lg hover:bg-rose-700 shadow-sm">Kirim Bukti</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div x-show="openDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" x-cloak>
        <div @click="openDetailModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full p-6 border border-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900">Detail Tagihan</h3>
                <button type="button" @click="openDetailModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="py-4 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-800" x-text="selectedBill.title"></h4>
                        <p class="text-xs text-slate-400 mt-0.5" x-text="selectedBill.period"></p>
                    </div>
                    <span :class="selectedBill.status === 'Lunas' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-amber-50 text-amber-600 border border-amber-200'"
                          class="px-2.5 py-1 text-[10px] font-bold uppercase rounded tracking-wider" x-text="selectedBill.status"></span>
                </div>
                <div class="border border-slate-100 rounded-lg overflow-hidden text-sm">
                    <div class="flex justify-between p-3 bg-slate-50/70 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Tanggal</span>
                        <span class="font-semibold text-slate-700" x-text="selectedBill.dateInfo || '-'"></span>
                    </div>
                    <div class="flex justify-between p-3">
                        <span class="text-slate-400 font-medium">Nominal</span>
                        <span class="font-bold text-slate-900" x-text="selectedBill.amount"></span>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" @click="openDetailModal = false" class="px-5 py-2 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-slate-800">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

