@extends('layouts.app', ['activePage' => 'pembayaran'])

@section('content')
<div class="max-w-7xl mx-auto py-8">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex justify-between mb-5">
        <form class="flex gap-2">
            <input
                type="text"
                name="search"
                placeholder="Cari penghuni / tagihan..."
                value="{{ request('search') }}"
                class="rounded-lg border-gray-300">
            <select name="status" class="rounded-lg border-gray-300">
                <option value="">Semua Status</option>
                <option value="unpaid" @selected(request('status')=='unpaid')>Belum Bayar</option>
                <option value="pending_verification" @selected(request('status')=='pending_verification')>Menunggu Verifikasi</option>
                <option value="paid" @selected(request('status')=='paid')>Lunas</option>
            </select>
            <button class="bg-gray-700 text-white px-4 rounded-lg">Filter</button>
        </form>
        <a
            href="{{ route('admin.payments.create') }}"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg">
            + Tambah Pembayaran
        </a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Tagihan</th>
                    <th>Penghuni</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($payments as $payment)
                <tr class="border-t">
                    <td class="p-3">
                        {{ $payment->bill->title ?? '-' }}
                        <div class="text-xs text-gray-400">{{ $payment->bill->period ?? '' }}</div>
                    </td>
                    <td>
                        {{ $payment->user->name ?? '-' }}
                    </td>
                    <td>
                        Rp {{ number_format($payment->split_amount,0,',','.') }}
                    </td>
                    <td>
                        @if($payment->status=='paid')
                            <span class="text-green-600">Lunas</span>
                        @elseif($payment->status=='pending_verification')
                            <span class="text-yellow-600">Menunggu Verifikasi</span>
                        @else
                            <span class="text-red-600">Belum Bayar</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <a
                                href="{{ route('admin.payments.edit',$payment) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Edit
                            </a>
                            <form
                                action="{{ route('admin.payments.destroy',$payment) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Hapus data pembayaran ini?')"
                                    class="bg-red-600 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-5">
                        Belum ada data pembayaran.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">
        {{ $payments->links() }}
    </div>
</div>
@endsection
