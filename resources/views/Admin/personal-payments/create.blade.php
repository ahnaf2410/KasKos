@extends('layouts.app', ['activePage' => 'tagihan'])
@section('content')
<div class="max-w-4xl mx-auto py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">
            Tambah Personal Payment
        </h1>

        <p class="text-gray-500 mt-1">
            Buat tagihan pembayaran sewa kamar untuk penghuni.
        </p>
    </div>

    <form
        action="{{ route('admin.personal-payments.store') }}"
        method="POST"
        class="bg-white rounded-3xl shadow-sm border p-8">

        @csrf

        <div class="grid grid-cols-2 gap-6">

            {{-- Kamar --}}
            <div>

                <label class="block font-semibold mb-2">
                    Kamar
                </label>

                <select
                    id="room"
                    name="room_id"
                    class="w-full rounded-xl border-gray-300">

                    <option value="">Pilih Kamar</option>

                    @foreach($rooms as $room)

                        <option
                            value="{{ $room->id }}"
                            data-price="{{ $room->rental_price }}"
                            @selected(old('room_id')==$room->id)>

                            {{ $room->room_number }}

                        </option>

                    @endforeach

                </select>

                @error('room_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            {{-- Penghuni --}}
            <div>

                <label class="block font-semibold mb-2">
                    Penghuni
                </label>

                <select
                    name="user_id"
                    class="w-full rounded-xl border-gray-300">

                    <option value="">Pilih Penghuni</option>

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected(old('user_id')==$user->id)>

                            {{ $user->name }}

                        </option>

                    @endforeach

                </select>

                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            {{-- Jenis --}}
            <div>

                <label class="block font-semibold mb-2">
                    Jenis Pembayaran
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title','Sewa Bulanan') }}"
                    class="w-full rounded-xl border-gray-300">

            </div>

            {{-- Nominal --}}
            <div>

                <label class="block font-semibold mb-2">
                    Nominal
                </label>

                <input
                    id="amount_display"
                    type="text"
                    readonly
                    class="w-full rounded-xl bg-gray-100 border-gray-300">

                <input
                    id="amount"
                    type="hidden"
                    name="amount">

                <p class="text-xs text-gray-500 mt-1">
                    Nominal otomatis mengikuti harga sewa kamar.
                </p>

            </div>

            {{-- Jatuh Tempo --}}
            <div>

                <label class="block font-semibold mb-2">
                    Jatuh Tempo
                </label>

                <input
                    type="date"
                    name="due_date"
                    value="{{ old('due_date') }}"
                    class="w-full rounded-xl border-gray-300">

            </div>

            {{-- Status --}}
            <div>

                <label class="block font-semibold mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-xl border-gray-300">

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

        </div>

        {{-- Catatan --}}

        <div class="mt-6">

            <label class="block font-semibold mb-2">
                Catatan
            </label>

            <textarea
                rows="4"
                name="notes"
                class="w-full rounded-xl border-gray-300">{{ old('notes') }}</textarea>

        </div>

        {{-- Tombol --}}

        <div class="flex justify-end gap-3 mt-8">

            <a
                href="{{ route('admin.personal-payments.index') }}"
                class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300">

                Batal

            </a>

            <button
                class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white">

                Simpan Pembayaran

            </button>

        </div>

    </form>

</div>

<script>

const roomSelect = document.getElementById('room');

const amountInput = document.getElementById('amount');

const amountDisplay = document.getElementById('amount_display');

roomSelect.addEventListener('change', function(){

    const option = this.options[this.selectedIndex];

    const price = option.dataset.price ?? 0;

    amountInput.value = price;

    amountDisplay.value =
        new Intl.NumberFormat('id-ID',{
            style:'currency',
            currency:'IDR',
            minimumFractionDigits:0
        }).format(price);

});

</script>

@endsection
