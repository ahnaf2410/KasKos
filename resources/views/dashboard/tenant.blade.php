@extends('layouts.tenant', ['activePage' => 'dashboard'])

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Tenant</h1>
            <p class="text-sm text-slate-500 mt-0.5">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-medium text-slate-400">{{ now()->format('d F Y') }}</p>
        </div>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tagihan Aktif</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">Rp {{ number_format($totalBill, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Pembayaran</p>
                    <p class="text-2xl font-bold mt-1 {{ $unpaid > 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $unpaid > 0 ? 'Belum Lunas' : 'Lunas' }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl {{ $unpaid > 0 ? 'bg-rose-50 text-rose-500' : 'bg-emerald-50 text-emerald-500' }} flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kamar</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $room->room_number ?? '-' }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pembayaran Sukses</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $payments->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Tagihan Table --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-900">Tagihan Aktif</h2>
                <a href="{{ route('tenant.tagihan.index') }}" class="text-xs font-semibold text-rose-600 hover:text-rose-700">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left">
                            <th class="px-5 py-3 font-semibold text-slate-500 text-xs uppercase">Tagihan</th>
                            <th class="px-5 py-3 font-semibold text-slate-500 text-xs uppercase">Nominal</th>
                            <th class="px-5 py-3 font-semibold text-slate-500 text-xs uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($allBills as $bill)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-5 py-3.5 text-slate-800 font-medium">{{ $bill['title'] }}</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">Rp {{ number_format($bill['amount'], 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5">
                                @if($bill['status'] == 'lunas')
                                <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-medium">Lunas</span>
                                @elseif($bill['status'] == 'pending')
                                <span class="bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full text-xs font-medium">Pending</span>
                                @else
                                <span class="bg-red-50 text-red-700 px-2.5 py-1 rounded-full text-xs font-medium">Belum Bayar</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-slate-400">Belum ada tagihan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- Info Kamar --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4">Informasi Kamar</h3>
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Nomor Kamar</p>
                        <p class="text-xl font-bold text-slate-900">{{ $room->room_number ?? '-' }}</p>
                        @if(isset($room->rental_price) && $room->rental_price > 0)
                        <p class="text-xs text-slate-400 mt-0.5">Rp {{ number_format($room->rental_price, 0, ',', '.') }}/bln</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Aktivitas --}}
            <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4">Aktivitas Pembayaran</h3>
                <div class="space-y-3">
                    @forelse($payments as $payment)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-slate-800">{{ $payment->title ?? 'Pembayaran' }}</p>
                            <span class="text-[10px] font-medium text-slate-400">{{ $payment->type ?? '' }}</span>
                        </div>
                        <span class="text-sm font-bold text-emerald-600">Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-slate-400 text-center py-4">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

