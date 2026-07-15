@extends('layouts.tenant', ['activePage' => 'dashboard'])

@section('content')

<div class="bg-white rounded-xl shadow p-6">

<h2 class="text-xl font-bold mb-6">

Riwayat Kamar

</h2>

@if($histories->count())

<table class="min-w-full">

<thead>

<tr>

<th>Kamar</th>

<th>Mulai</th>

<th>Selesai</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($histories as $history)

<tr>

<td>{{ $history->room->room_number }}</td>

<td>{{ $history->start_date }}</td>

<td>{{ $history->end_date ?? '-' }}</td>

<td>{{ ucfirst($history->status) }}</td>

</tr>

@endforeach

</tbody>

</table>

{{ $histories->links() }}

@else

<div class="text-gray-500">

Belum ada riwayat.

</div>

@endif

</div>

@endsection