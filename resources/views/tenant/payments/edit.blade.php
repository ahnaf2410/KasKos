@extends('layouts.app', ['activePage' => 'pembayaran'])

@section('content')
<div class="max-w-md mx-auto py-8">

    <h1 class="text-2xl font-bold mb-1">
        Ganti Bukti Pembayaran
    </h1>

    <p class="text-gray-500 mb-6">
        {{ $payment->bill->title }} &middot; {{ $payment->bill->period }}
    </p>

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between text-sm mb-4">
            <span class="text-gray-500">Nominal</span>
            <span class="text-red-600 font-semibold">
                Rp {{ number_format($payment->split_amount,0,',','.') }}
            </span>
        </div>

        <p class="text-sm text-gray-500 mb-2">Bukti saat ini:</p>
        <img
            src="{{ asset('storage/'.$payment->payment_slip) }}"
            class="w-full h-40 object-cover rounded-lg mb-6 border">

        <form action="{{ route('tenant.payments.update', $payment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="block mb-1 text-sm font-medium">Ganti dengan bukti baru</label>
            <input type="file" name="payment_slip" accept="image/*" class="w-full mb-2">
            @error('payment_slip')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('tenant.payments.index') }}" class="px-4 py-2 rounded-lg bg-gray-200">
                    Batal
                </a>
                <button class="px-4 py-2 rounded-lg bg-yellow-500 text-white">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>

</div>
@endsection