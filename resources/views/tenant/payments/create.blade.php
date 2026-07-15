@extends('layouts.tenant')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-xl shadow p-8">

        <h1 class="text-2xl font-bold mb-6">
            Pembayaran Kamar
        </h1>

        <div class="space-y-3">

            <p>
                Nomor Kamar :
                <strong>{{ $room->room_number }}</strong>
            </p>

            <p>
                Lantai :
                {{ $room->floor }}
            </p>

            <p class="text-2xl font-bold text-blue-600">
                Rp {{ number_format($room->rental_price) }}
            </p>

        </div>

        <form
            action="{{ route('tenant.payments.store') }}"
            method="POST"
            class="mt-8">

            @csrf

            <button
                class="w-full bg-green-600 text-white py-3 rounded-lg">

                Bayar Sekarang

            </button>

        </form>

    </div>

</div>

@endsection