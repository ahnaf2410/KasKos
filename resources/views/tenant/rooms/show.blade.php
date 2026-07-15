@extends('layouts.tenant', ['activePage' => 'dashboard'])

@section('content')

<div class="p-6 bg-gray-100 min-h-screen">

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Detail Kamar
        </h1>

        <p class="text-gray-500 mt-2">
            Lihat informasi lengkap sebelum memilih kamar.
        </p>

    </div>


    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            {{-- Header Card --}}
            <div class="bg-blue-600 text-white p-6 flex justify-between items-center">

                <div>

                    <h2 class="text-3xl font-bold">
                        Kamar {{ $room->room_number }}
                    </h2>

                    <p class="opacity-90">
                        Lantai {{ $room->floor }}
                    </p>

                </div>

                @if($room->status == 'vacant')

                    <span class="bg-green-500 px-4 py-2 rounded-full font-semibold">
                        Kosong
                    </span>

                @else

                    <span class="bg-red-500 px-4 py-2 rounded-full font-semibold">
                        Terisi
                    </span>

                @endif

            </div>


            {{-- Body --}}
            <div class="p-8">

                <div class="grid md:grid-cols-2 gap-6">

                    <div class="bg-gray-50 rounded-xl p-5">

                        <p class="text-gray-500">
                            Nomor Kamar
                        </p>

                        <h3 class="text-2xl font-bold">
                            {{ $room->room_number }}
                        </h3>

                    </div>

                    <div class="bg-gray-50 rounded-xl p-5">

                        <p class="text-gray-500">
                            Lantai
                        </p>

                        <h3 class="text-2xl font-bold">
                            {{ $room->floor }}
                        </h3>

                    </div>

                    <div class="bg-gray-50 rounded-xl p-5">

                        <p class="text-gray-500">
                            Harga Sewa
                        </p>

                        <h3 class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($room->rental_price,0,',','.') }}
                        </h3>

                    </div>

                    <div class="bg-gray-50 rounded-xl p-5">

                        <p class="text-gray-500">
                            Status
                        </p>

                        <h3 class="text-2xl font-bold">
                            {{ ucfirst($room->status) }}
                        </h3>

                    </div>

                </div>


                {{-- Deskripsi --}}
                <div class="mt-8">

                    <h3 class="font-bold text-xl mb-3">
                        Deskripsi
                    </h3>

                    <div class="bg-gray-50 rounded-xl p-5">

                        {{ $room->description ?: 'Belum ada deskripsi kamar.' }}

                    </div>

                </div>


                {{-- Tombol --}}
                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('tenant.rooms.index') }}"
                       class="px-5 py-3 rounded-lg border border-gray-300 hover:bg-gray-100">

                        Kembali

                    </a>

                    @if($room->status == 'vacant')

                    <form action="{{ route('tenant.rooms.select', $room) }}" method="POST">
    @csrf

    <button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">
        Pilih Kamar
    </button>
</form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection