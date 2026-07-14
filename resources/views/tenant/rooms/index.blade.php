@extends('layouts.app')


@section('content')

<div class="container mx-auto px-6 py-8">


<h1 class="text-3xl font-bold mb-6">
Kamar Saya
</h1>



@if($currentRoom)


<div class="bg-white shadow rounded-lg p-6 mb-6">


<h2 class="text-xl font-bold mb-4">
Informasi Kamar
</h2>


<p>
Nomor Kamar :

<b>
{{ $currentRoom->room->room_number }}
</b>

</p>


<p>
Status :

<span class="text-green-600">
{{ $currentRoom->room->status }}
</span>

</p>


<p>
Harga :

Rp {{ number_format($currentRoom->room->price) }}

</p>


</div>





<div class="bg-white shadow rounded-lg p-6 mb-6">


<h2 class="text-xl font-bold mb-4">
Penghuni Satu Kamar
</h2>



@foreach($currentRoom->room->users as $tenant)


<p>
{{ $tenant->name }}
</p>


@endforeach



</div>






<div class="bg-white shadow rounded-lg p-6">


<h2 class="text-xl font-bold mb-4">
Fasilitas Kamar
</h2>



@foreach($currentRoom->room->facilities as $facility)


<p>
- {{ $facility->name }}
</p>


@endforeach



</div>



@else


<div class="bg-yellow-100 p-5 rounded">

Belum memiliki kamar

</div>


@endif





<div class="bg-white shadow rounded-lg p-6 mt-6">


<h2 class="text-xl font-bold mb-4">
Riwayat Perpindahan Kamar
</h2>



<table class="w-full">


<thead>

<tr>
<th>
Kamar
</th>

<th>
Mulai
</th>

<th>
Selesai
</th>

</tr>

</thead>



<tbody>


@foreach($roomHistories as $history)


<tr>

<td>
{{ $history->room->room_number }}
</td>


<td>
{{ $history->start_date }}
</td>


<td>

{{ $history->end_date ?? '-' }}

</td>


</tr>


@endforeach



</tbody>


</table>


</div>



</div>


@endsection