@extends('layouts.tenant', ['activePage' => 'pembayaran'])

@section('content')
<div class="max-w-md mx-auto py-8">

    <h1 class="text-2xl font-bold mb-1">
        Detail Pembayaran
    </h1>

    <p class="text-gray-500 mb-6">
        {{ $payment->bill->title }} &middot; {{ $payment->bill->period }}
    </p>

    <div class="bg-white rounded-xl shadow p-6">

        @if($payment->payment_slip)
            <img
                src="{{ asset('storage/'.$payment->payment_slip) }}"
                class="w-full h-64 object-cover rounded-lg mb-6 border">
        @else
            <div class="w-full h-64 flex items-center justify-center bg-gray-50 rounded-lg mb-6 border text-gray-400">
                Belum ada bukti diupload
            </div>
        @endif

        <div class="space-y-3 text-sm">

            <div class="flex justify-between">
                <span class="text-gray-500">Nominal</span>
                <span class="font-semibold">Rp {{ number_format($payment->split_amount,0,',','.') }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Status</span>
                @if($payment->status=='paid')
                    <span class="text-green-600 font-medium">Lunas</span>
                @elseif($payment->status=='pending_verification')
                    <span class="text-yellow-600 font-medium">Menunggu Verifikasi</span>
                @else
                    <span class="text-red-600 font-medium">Belum Bayar</span>
                @endif
            </div>

            @if($payment->payment_date)
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Upload</span>
                    <span>{{ $payment->payment_date->format('d M Y') }}</span>
                </div>
            @endif

            @if($payment->verifier)
                <div class="flex justify-between">
                    <span class="text-gray-500">Diverifikasi Oleh</span>
                    <span>{{ $payment->verifier->name }}</span>
                </div>
            @endif

            @if($payment->notes)
                <div class="pt-3 border-t">
                    <span class="text-gray-500 block mb-1">Catatan Admin</span>
                    <p class="text-slate-700">{{ $payment->notes }}</p>
                </div>
            @endif

        </div>

        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('tenant.payments.index') }}" class="px-4 py-2 rounded-lg bg-gray-200">
                Kembali
            </a>
            @if($payment->status !== 'paid')
                <a href="{{ route('tenant.payments.edit', $payment) }}" class="px-4 py-2 rounded-lg bg-yellow-500 text-white">
                    Ganti Bukti
                </a>
            @endif
        </div>

    </div>

</div>
@endsection