@extends('layouts.tenant', ['activePage' => 'pembayaran'])

@section('content')
<div class="max-w-md mx-auto py-8">

    <h1 class="text-2xl font-bold mb-1">
        Upload Bukti Pembayaran
    </h1>

    <p class="text-gray-500 mb-6">
        {{ $payment->bill->title }} &middot; {{ $payment->bill->period }}
    </p>

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between text-sm mb-6 pb-4 border-b">
            <span class="text-gray-500">Nominal yang harus dibayar</span>
            <span class="text-red-600 font-semibold">
                Rp {{ number_format($payment->split_amount,0,',','.') }}
            </span>
        </div>

        <form action="{{ route('tenant.payments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="payment_id" value="{{ $payment->id }}">

            <label class="block mb-1 text-sm font-medium">Bukti Transfer (gambar)</label>
            <input type="file" name="payment_slip" accept="image/*" class="w-full mb-2">
            @error('payment_slip')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('tenant.payments.index') }}" class="px-4 py-2 rounded-lg bg-gray-200">
                    Batal
                </a>
                <button class="px-4 py-2 rounded-lg bg-red-600 text-white">
                    Upload
                </button>
            </div>
        </form>

    </div>

</div>
@endsection