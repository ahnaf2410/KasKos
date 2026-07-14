@extends('layouts.app', ['activePage' => 'tagihan'])


@section('content')
<div class="max-w-7xl mx-auto py-8">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Personal Payment
            </h1>

            <p class="text-gray-500 mt-1">
                Halaman untuk mengelola pembayaran sewa kamar penghuni.
            </p>
        </div>

        <a href="{{ route('admin.personal-payments.create') }}"
            class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-xl shadow">
            + Tambah Pembayaran
        </a>

    </div>


    {{-- Statistik --}}
    <div class="grid grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl border p-6 shadow-sm">

            <p class="text-gray-500 font-semibold uppercase text-sm">
                Total Tagihan
            </p>

            <h2 class="text-4xl font-bold mt-3">
                {{ $payments->total() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl border p-6 shadow-sm">

            <p class="text-gray-500 font-semibold uppercase text-sm">
                Lunas
            </p>

            <h2 class="text-4xl font-bold text-green-600 mt-3">
                {{ $payments->where('status','paid')->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl border p-6 shadow-sm">

            <p class="text-gray-500 font-semibold uppercase text-sm">
                Menunggu
            </p>

            <h2 class="text-4xl font-bold text-yellow-500 mt-3">
                {{ $payments->where('status','pending_verification')->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl border p-6 shadow-sm">

            <p class="text-gray-500 font-semibold uppercase text-sm">
                Belum Bayar
            </p>

            <h2 class="text-4xl font-bold text-red-600 mt-3">
                {{ $payments->where('status','unpaid')->count() }}
            </h2>

        </div>

    </div>



    {{-- Filter --}}
    <form class="bg-white rounded-2xl border p-5 mb-8">

        <div class="grid grid-cols-4 gap-5">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari pembayaran atau nama penghuni..."
                class="rounded-xl border-gray-300">

            <select class="rounded-xl border-gray-300">

                <option>Semua Bulan</option>

            </select>

            <select class="rounded-xl border-gray-300">

                <option>2026</option>

            </select>

            <select
                name="status"
                class="rounded-xl border-gray-300">

                <option value="">Semua Status</option>

                <option value="unpaid">
                    Belum Bayar
                </option>

                <option value="pending_verification">
                    Menunggu Verifikasi
                </option>

                <option value="paid">
                    Lunas
                </option>

            </select>

        </div>

    </form>



    {{-- Table --}}
    <div class="bg-white rounded-3xl border overflow-hidden shadow-sm">

        <table class="w-full">

            <thead class="bg-slate-100 text-slate-700">

            <tr>

                <th class="p-5 text-left">Nama Penghuni</th>

                <th>No. Kamar</th>

                <th>Jenis</th>

                <th>Nominal</th>

                <th>Jatuh Tempo</th>

                <th>Status</th>

                <th width="160">Aksi</th>

            </tr>

            </thead>

            <tbody>

            @forelse($payments as $payment)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-full bg-red-100 flex items-center justify-center font-bold text-red-700">

                            {{ strtoupper(substr($payment->user?->name ?? '--',0,2)) }}

                        </div>

                        <div>

                            <div class="font-semibold">

                                {{ $payment->user?->name ?? '-' }}

                            </div>

                        </div>

                    </div>

                </td>

                <td>

                    {{ $payment->room?->room_number ?? '-' }}

                </td>

                <td>

                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">

                        {{ $payment->title ?? 'Sewa Bulanan' }}

                    </span>

                </td>

                <td class="font-semibold">

                    Rp {{ number_format($payment->amount,0,',','.') }}

                </td>

                <td>

                    {{ $payment->due_date?->format('d M Y') ?? '-' }}

                </td>

                <td>

                    @if($payment->status=='paid')

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                            Lunas

                        </span>

                    @elseif($payment->status=='pending_verification')

                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

                            Menunggu

                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">

                            Belum Bayar

                        </span>

                    @endif

                </td>

                <td>

                    <div class="flex gap-3 justify-center">

                        <a
                            href="{{ route('admin.personal-payments.edit',$payment) }}"
                            class="text-blue-600 hover:text-blue-800">

                            ✏️

                        </a>

                        <form
                            action="{{ route('admin.personal-payments.destroy',$payment) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus pembayaran?')"
                                class="text-red-600 hover:text-red-800">

                                🗑️

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7" class="text-center py-10 text-gray-500">

                    Belum ada pembayaran.

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-8">

        {{ $payments->links() }}

    </div>

</div>
@endsection
