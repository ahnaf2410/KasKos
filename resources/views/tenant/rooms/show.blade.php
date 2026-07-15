@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
    {{ session('error') }}
</div>
@endif

<div class="container">

<h2>Detail Kamar</h2>

<table class="table">

<tr>

<th>Nomor</th>

<td>{{ $room->room_number }}</td>

</tr>

<tr>

<th>Lantai</th>

<td>{{ $room->floor }}</td>

</tr>

<tr>

<th>Harga</th>

<td>Rp {{ number_format($room->rental_price) }}</td>

</tr>

<tr>

<th>Status</th>

<td>{{ ucfirst($room->status) }}</td>

</tr>

<tr>

<th>Deskripsi</th>

<td>{{ $room->description }}</td>

</tr>

</table>

<form action="{{ route('tenant.rooms.select',$room) }}" method="POST">

    @csrf

    <button
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

        Pilih Kamar

    </button>

</form>
</div>

@endsection