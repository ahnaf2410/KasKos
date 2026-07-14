@extends('layouts.app', ['activePage' => 'rooms'])

@section('content')

<div class="max-w-7xl mx-auto py-8">

    @if(session('success'))
        <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Manajemen Kamar
            </h1>
            <p class="text-gray-500 mt-1">
                Kelola seluruh data kamar kos.
            </p>
        </div>

        <a href="{{ route('admin.rooms.create') }}"
           class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl shadow font-semibold">
            + Tambah Kamar
        </a>

    </div>

    {{-- Search --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-8">

<form method="GET">

<div class="grid md:grid-cols-4 gap-4">

    {{-- Search --}}
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari kamar..."
        class="rounded-xl border-gray-300">

    {{-- Status --}}
    <select
        name="status"
        class="rounded-xl border-gray-300">

        <option value="">Semua Status</option>

        <option
            value="vacant"
            @selected(request('status')=='vacant')>

            Kosong

        </option>

        <option
            value="occupied"
            @selected(request('status')=='occupied')>

            Terisi

        </option>

    </select>

    {{-- Floor --}}
    <select
        name="floor"
        class="rounded-xl border-gray-300">

        <option value="">Semua Lantai</option>

        @for($i=1;$i<=10;$i++)

            <option
                value="{{ $i }}"
                @selected(request('floor')==$i)>

                Lantai {{ $i }}

            </option>

        @endfor

    </select>

    <button
        class="bg-blue-600 text-white rounded-xl">

        Filter

    </button>

</div>

</form>

</div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100 text-gray-700">

                <tr>

                    <th class="text-left px-6 py-4">
                        Nomor Kamar
                    </th>

                    <th class="text-left">
                        Lantai
                    </th>

                    <th class="text-left">
                        Penghuni
                    </th>

                    <th class="text-left">
                        Harga Sewa
                    </th>

                    <th class="text-left">
                        Status
                    </th>

                    <th class="text-center w-44">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($rooms as $room)

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-6 py-5 font-semibold">

                        {{ $room->room_number }}

                    </td>

                    <td>

                        Lantai {{ $room->floor }}

                    </td>

                    <td>

                        {{ $room->tenant?->name ?? 'Belum Ada' }}

                    </td>

                    <td>

                        Rp {{ number_format($room->rental_price,0,',','.') }}

                    </td>

                    <td>

                        @if($room->status=='occupied')

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-sm font-semibold">
                                Terisi
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-sm font-semibold">
                                Kosong
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('admin.rooms.edit',$room) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>

                            <form action="{{ route('admin.rooms.destroy',$room) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Hapus kamar ini?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="py-8 text-center text-gray-500">

                        Belum ada data kamar.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6 flex justify-between items-center">

    <div class="text-sm text-gray-500">

        Menampilkan

        {{ $rooms->firstItem() }}

        -

        {{ $rooms->lastItem() }}

        dari

        {{ $rooms->total() }}

        kamar

    </div>

    {{ $rooms->links() }}

</div>

</div>

@endsection