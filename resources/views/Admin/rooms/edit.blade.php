@extends('layouts.app', ['activePage' => 'rooms'])

@section('content')

<div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn">

    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl overflow-hidden animate-modal">

        {{-- Header --}}
        <div class="flex justify-between items-center px-7 py-5 border-b">
            <h2 class="text-2xl font-bold text-gray-800">
                Edit Kamar
            </h2>

            <a href="{{ route('admin.rooms.index') }}"
               class="text-gray-400 hover:text-gray-700 text-3xl leading-none">
                &times;
            </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.rooms.update',$room) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="p-7">

                {{-- Nomor Kamar --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-2">
                        Nomor Kamar
                    </label>

                    <input
                        type="text"
                        name="room_number"
                        value="{{ old('room_number',$room->room_number) }}"
                        class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-400">

                    @error('room_number')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-2">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-400">{{ old('description',$room->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-5">

                    {{-- Lantai --}}
                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Lantai
                        </label>

                        <input
                            type="number"
                            name="floor"
                            value="{{ old('floor',$room->floor) }}"
                            class="w-full border rounded-xl px-4 py-3">

                        @error('floor')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Harga Sewa
                        </label>

                        <input
                            type="number"
                            name="rental_price"
                            value="{{ old('rental_price',$room->rental_price) }}"
                            class="w-full border rounded-xl px-4 py-3">

                        @error('rental_price')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Penghuni --}}
                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Penghuni
                        </label>

                        <select
                            name="tenant_id"
                            class="w-full border rounded-xl px-4 py-3">

                            <option value="">Kosong</option>

                            @foreach($tenants as $tenant)

                                <option
                                    value="{{ $tenant->id }}"
                                    {{ old('tenant_id',$room->tenant_id)==$tenant->id ? 'selected' : '' }}>

                                    {{ $tenant->name }}

                                </option>

                            @endforeach

                        </select>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Status
                        </label>

                        <input
                            type="text"
                            readonly
                            value="{{ $room->tenant_id ? 'Occupied' : 'Vacant' }}"
                            class="w-full border rounded-xl px-4 py-3 bg-gray-100">

                        <small class="text-gray-500">
                            Status mengikuti penghuni.
                        </small>
                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="border-t px-7 py-5 flex justify-end gap-3">

                <a
                    href="{{ route('admin.rooms.index') }}"
                    class="px-6 py-3 rounded-xl border hover:bg-gray-100">

                    Batal

                </a>

                <button
                    class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl shadow">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>

@endsection