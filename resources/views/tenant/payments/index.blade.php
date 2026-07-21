@extends('layouts.tenant', ['activePage' => 'tagihan'])

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
            <p class="text-sm text-slate-500 mt-0.5">Upload bukti pembayaran tagihan patungan.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Tagihan</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Periode</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Nominal</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Status</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Bukti</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-5 py-4 font-medium text-slate-800">{{ $payment->bill->title }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $payment->bill->period }}</td>
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
                        <td class="px-5 py-4 text-slate-600 text-xs">
                            @if($payment->payment_slip)
                                <span class="bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded text-xs font-medium">✅ Terupload</span>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex gap-2">
                                @if(!$payment->payment_slip)
                                    <a href="{{ route('tenant.payments.create', ['payment' => $payment->id]) }}" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg transition">Upload</a>
                                @else
                                    <a href="{{ route('tenant.payments.show', $payment) }}" class="px-3 py-1.5 bg-slate-600 hover:bg-slate-700 text-white text-xs font-semibold rounded-lg transition">Preview</a>
                                    @if($payment->status !== 'paid')
                                        <a href="{{ route('tenant.payments.edit', $payment) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg transition">Edit</a>
                                        <form action="{{ route('tenant.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Hapus bukti?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-slate-300 hover:bg-slate-400 text-slate-700 text-xs font-semibold rounded-lg transition">Hapus</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-400">Tidak ada pembayaran.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $payments->links() }}</div>
</div>
@endsection

