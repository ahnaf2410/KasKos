@extends('layouts.app', ['activePage' => 'tagihan'])
@section('content')
<div class="max-w-4xl mx-auto py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">
            Edit Personal Payment
        </h1>

        <p class="text-gray-500 mt-1">
            Perbarui data pembayaran sewa kamar penghuni.
        </p>
    </div>

    <form
        action="{{ route('admin.personal-payments.update', $payment) }}"
        method="POST"
        class="bg-white rounded-3xl shadow-sm border p-8">

        @csrf
        @method('PUT')

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

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            data-price="{{ $user->room?->rental_price ?? 0 }}"
                            @selected($payment->user_id == $user->id)>

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
                    value="{{ old('title', $payment->title) }}"
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
                    value="{{ old('amount', $payment->amount) }}"
                    class="w-full rounded-xl bg-gray-100 border-gray-300"
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
                    value="{{ old('due_date', optional($payment->due_date)->format('Y-m-d')) }}"
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

                    <option
                        value="unpaid"
                        @selected($payment->status == 'unpaid')>
                        Belum Bayar
                    </option>

                    <option
                        value="pending_verification"
                        @selected($payment->status == 'pending_verification')>
                        Menunggu Verifikasi
                    </option>

                    <option
                        value="paid"
                        @selected($payment->status == 'paid')>
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
                class="w-full rounded-xl border-gray-300">{{ old('notes', $payment->notes) }}</textarea>

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

                Update Pembayaran

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

// Auto-fill on page load
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('user_id');
    if (select.value) {
        autoFillAmount(select);
    }
});
</script>

@endsection
