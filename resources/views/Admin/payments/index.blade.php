@extends('layouts.app', ['activePage' => 'pembayaran'])

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pembayaran Patungan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola pembayaran tagihan patungan penghuni.</p>
        </div>
        <a href="{{ route('admin.payments.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Pembayaran
        </a>
    </div>

    {{-- Filter --}}
    <form class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <input type="text" name="search" placeholder="Cari penghuni / tagihan..." value="{{ request('search') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
            <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                <option value="">Semua Status</option>
                <option value="unpaid" @selected(request('status')=='unpaid')>Belum Bayar</option>
                <option value="pending_verification" @selected(request('status')=='pending_verification')>Menunggu Verifikasi</option>
                <option value="paid" @selected(request('status')=='paid')>Lunas</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-lg transition">Filter</button>
                <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-lg transition">Reset</a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Tagihan</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Penghuni</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Jumlah</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Status</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-5 py-4">
                            <p class="font-medium text-slate-800">{{ $payment->bill->title ?? '-' }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $payment->bill->period ?? '' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-xs font-bold text-rose-700">
                                    {{ strtoupper(substr($payment->user->name ?? '--', 0, 2)) }}
                                </div>
                                <span class="text-slate-800">{{ $payment->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 font-semibold text-slate-800">Rp {{ number_format($payment->split_amount, 0, ',', '.') }}</td>
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
                                <a href="{{ route('admin.payments.edit', $payment) }}" class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Hapus data pembayaran ini?')">
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
                        <td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada data pembayaran.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $payments->links() }}</div>
</div>
@endsection

