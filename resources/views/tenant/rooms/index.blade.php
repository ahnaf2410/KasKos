@extends('layouts.tenant', ['activePage' => 'dashboard'])

@section('content')

<div class="p-6 bg-gray-100 min-h-screen">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Pilih Kamar
        </h1>

        <p class="text-gray-500 mt-2">
            Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
            Kamu belum memiliki kamar. Silakan pilih salah satu kamar yang masih tersedia.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-gray-500">Kamar Tersedia</p>
            <h2 class="text-3xl font-bold text-blue-600">
                {{ $rooms->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-gray-500">Status</p>
            <h2 class="text-xl font-bold text-orange-500">
                Belum Memiliki Kamar
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-gray-500">Langkah Selanjutnya</p>
            <h2 class="text-lg font-semibold">
                Pilih kamar → Bayar → Check-in
            </h2>
        </div>

    </div>

    {{-- Daftar kamar --}}
    <h2 class="text-2xl font-bold mb-5">
        Daftar Kamar Tersedia
    </h2>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($rooms as $room)

<div class="bg-white rounded-xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <h2 class="text-xl font-bold">
                Kamar {{ $room->room_number }}
            </h2>

            <p class="text-gray-500">
                Lantai {{ $room->floor }}
            </p>

        </div>

        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">
            Kosong
        </span>

    </div>

    <div class="mt-4">

        <p class="text-2xl font-bold text-blue-600">
            Rp {{ number_format($room->rental_price,0,',','.') }}
        </p>

    </div>

    <div class="mt-6 flex gap-2">

        <a href="{{ route('tenant.rooms.show', $room) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

            Detail

        </a>

    </div>

</div>

@empty

<div class="col-span-3">

    <div class="bg-white rounded-xl shadow p-10 text-center">

        <h2 class="text-xl font-bold text-gray-700">
            Tidak ada kamar yang tersedia
        </h2>

        <p class="text-gray-500 mt-2">
            Semua kamar saat ini sudah terisi.
        </p>

    </div>

</div>

@endforelse

</div>

</div>

@endsection