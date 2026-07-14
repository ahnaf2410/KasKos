@extends('layouts.app', ['activePage' => 'rooms'])

@section('content')

<div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn">

    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl overflow-hidden animate-modal">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b px-8 py-6">

            <h2 class="text-3xl font-bold text-gray-800">
                Tambah Kamar
            </h2>

            <a href="{{ route('admin.rooms.index') }}"
               class="text-3xl text-gray-400 hover:text-red-500 transition">

                &times;

            </a>

        </div>

        <form action="{{ route('admin.rooms.store') }}" method="POST">

            @csrf

            <div class="space-y-6 p-8">

                {{-- Nomor Kamar --}}
                <div>

                    <label class="mb-2 block font-semibold text-gray-700">
                        Nomor Kamar
                    </label>

                    <input
                        type="text"
                        name="room_number"
                        value="{{ old('room_number') }}"
                        placeholder="Contoh : A-01"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-red-500 focus:ring-red-500">

                    @error('room_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Deskripsi --}}
                <div>

                    <label class="mb-2 block font-semibold text-gray-700">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        placeholder="Masukkan deskripsi kamar..."
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('description') }}</textarea>

                </div>

                <div class="grid grid-cols-2 gap-6">

                    {{-- Lantai --}}
                    <div>

                        <label class="mb-2 block font-semibold text-gray-700">
                            Lantai
                        </label>

                        <input
                            type="number"
                            name="floor"
                            value="{{ old('floor') }}"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-red-500 focus:ring-red-500">

                        @error('floor')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Harga --}}
                    <div>

                        <label class="mb-2 block font-semibold text-gray-700">
                            Harga Sewa
                        </label>

                        <input
                            type="number"
                            name="rental_price"
                            value="{{ old('rental_price') }}"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-red-500 focus:ring-red-500">

                        @error('rental_price')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                    </div>

                </div>

                <div class="grid grid-cols-2 gap-6">

                    {{-- Penghuni --}}
                    <div>

                        <label class="mb-2 block font-semibold text-gray-700">
                            Penghuni
                        </label>

                        <select
                            id="tenantSelect"
                            name="tenant_id"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-red-500 focus:ring-red-500">

                            <option value="">Kosong</option>

                            @foreach($tenants as $tenant)

                                <option
                                    value="{{ $tenant->id }}"
                                    @selected(old('tenant_id')==$tenant->id)>

                                    {{ $tenant->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Status --}}
                    <div>

                        <label class="mb-2 block font-semibold text-gray-700">
                            Status
                        </label>

                        <div
                            id="statusBadge"
                            class="rounded-xl bg-green-100 px-4 py-3 font-semibold text-green-700">

                            🟢 Kosong

                        </div>

                        <small class="text-gray-500">
                            Status berubah otomatis berdasarkan penghuni.
                        </small>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-4 border-t px-8 py-5">

                <a
                    href="{{ route('admin.rooms.index') }}"
                    class="rounded-xl px-6 py-3 font-semibold text-gray-600 hover:bg-gray-100">

                    Batal

                </a>

                <button
                    class="rounded-xl bg-red-600 px-8 py-3 font-semibold text-white shadow hover:bg-red-700">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<script>

const tenant = document.getElementById('tenantSelect');
const badge = document.getElementById('statusBadge');

function updateStatus(){

    if(tenant.value){

        badge.innerHTML='🔴 Terisi';

        badge.className='rounded-xl bg-red-100 px-4 py-3 font-semibold text-red-700';

    }else{

        badge.innerHTML='🟢 Kosong';

        badge.className='rounded-xl bg-green-100 px-4 py-3 font-semibold text-green-700';

    }

}

tenant.addEventListener('change',updateStatus);

updateStatus();

</script>

@endsection