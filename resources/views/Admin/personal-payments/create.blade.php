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

            {{-- Penghuni --}}
            <div>

                <label class="block font-semibold mb-2">
                    Penghuni
                </label>

                <select
                    name="user_id"
                    id="user_id"
                    class="w-full rounded-xl border-gray-300"
                    onchange="autoFillAmount(this)">

                    <option value="" data-price="0">Pilih Penghuni</option>

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            data-price="{{ $user->room?->rental_price ?? 0 }}"
                            @selected(old('user_id')==$user->id)>

                            {{ $user->name }} {{ $user->room ? '(Kamar '.$user->room->room_number.')' : '(Belum punya kamar)' }}

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
                id="amount"
                type="number"
                name="amount"
                value="{{ old('amount', isset($payment) ? $payment->amount : '') }}"
                class="w-full rounded-xl border-gray-300"
                placeholder="Nominal otomatis terisi"
                readonly>

                <p class="text-xs text-gray-500 mt-1">
                    Nominal otomatis mengikuti harga sewa kamar penghuni.
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
function autoFillAmount(select) {
    const selected = select.options[select.selectedIndex];
    const price = selected ? parseFloat(selected.dataset.price) || 0 : 0;
    document.getElementById('amount').value = price;
}

// Auto-fill on page load if old value exists
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('user_id');
    if (select.value) {
        autoFillAmount(select);
    }
});
</script>

@endsection
