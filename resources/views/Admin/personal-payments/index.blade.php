@extends('layouts.app', ['activePage' => 'tagihan'])

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pembayaran Sewa</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola pembayaran sewa kamar penghuni.</p>
        </div>
        <a href="{{ route('admin.personal-payments.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Pembayaran
        </a>
    </div>

    {{-- Statistik Baris --}}
    @php
        $totalPayments = $payments->total();
        $lunasCount = $payments->where('status', 'paid')->count();
        $pendingCount = $payments->where('status', 'pending_verification')->count();
        $unpaidCount = $payments->where('status', 'unpaid')->count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
            <p class="text-xs font-semibold text-slate-400">Total</p>
            <p class="text-xl font-bold text-slate-900 mt-1">{{ $totalPayments }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
            <p class="text-xs font-semibold text-slate-400">Lunas</p>
            <p class="text-xl font-bold text-emerald-600 mt-1">{{ $lunasCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
            <p class="text-xs font-semibold text-slate-400">Menunggu</p>
            <p class="text-xl font-bold text-amber-500 mt-1">{{ $pendingCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
            <p class="text-xs font-semibold text-slate-400">Belum Bayar</p>
            <p class="text-xl font-bold text-rose-600 mt-1">{{ $unpaidCount }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.personal-payments.index') }}" class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari penghuni..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
            <select name="month" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                <option value="">Semua Bulan</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                @endfor
            </select>
            <select name="year" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                <option value="">Semua Tahun</option>
                @for($y = now()->year; $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                <option value="">Semua Status</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="pending_verification" {{ request('status') == 'pending_verification' ? 'selected' : '' }}>Menunggu</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>
        <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('admin.personal-payments.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-lg transition">Reset</a>
            <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-lg transition">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Penghuni</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">No. Kamar</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Tagihan</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Nominal</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Jatuh Tempo</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Status</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-rose-100 flex items-center justify-center text-xs font-bold text-rose-700">
                                    {{ strtoupper(substr($payment->user?->name ?? '--', 0, 2)) }}
                                </div>
                                <span class="font-medium text-slate-800">{{ $payment->user?->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ $payment->user?->room?->room_number ?? '-' }}</td>
                        <td class="px-5 py-4">
                            <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $payment->title ?? 'Sewa' }}</span>
                        </td>
                        <td class="px-5 py-4 font-semibold text-slate-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 text-slate-500 text-xs">{{ $payment->due_date?->format('d M Y') ?? '-' }}</td>
                        <td class="px-5 py-4">
                            @if($payment->status == 'paid')
                                <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-medium">Lunas</span>
                            @elseif($payment->status == 'pending_verification')
                                <span class="bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full text-xs font-medium">Menunggu</span>
                            @else
                                <span class="bg-red-50 text-red-700 px-2.5 py-1 rounded-full text-xs font-medium">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.personal-payments.edit', $payment) }}" class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.personal-payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Hapus pembayaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-slate-400">Belum ada data pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $payments->links() }}
    </div>

</div>
@endsection

