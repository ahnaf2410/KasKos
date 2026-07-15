@extends('layouts.tenant')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Dashboard Tenant
</h1>

@if($tenant->selectedRoom)

<div class="bg-white rounded-xl shadow p-6 mb-6">

    <h2 class="text-lg font-bold mb-4">
        Kamar Dipilih
    </h2>

    <div class="space-y-2">

        <p>Nomor : <strong>{{ $tenant->selectedRoom->room_number }}</strong></p>

        <p>Lantai : {{ $tenant->selectedRoom->floor }}</p>

        <p>Harga : Rp {{ number_format($tenant->selectedRoom->rental_price) }}</p>

        <span class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
            Menunggu Pembayaran
        </span>

    </div>

</div>

@endif

@endsection