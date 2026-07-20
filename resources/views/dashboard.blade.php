@extends('layouts.tenant', ['activePage' => 'dashboard'])

@section('content')

<div class="container mx-auto px-6 py-8">


<h1 class="text-3xl font-bold mb-6">
    Dashboard Tenant
</h1>


<!-- PROFILE -->
<div class="bg-white shadow rounded-lg p-6 mb-6">

<h2 class="text-xl font-semibold mb-4">
    Profil Tenant
</h2>

<p>
    Nama :
    <b>{{ $user->name }}</b>
</p>

<p>
    Email :
    {{ $user->email }}
</p>

<p>
    Nomor HP :
    {{ $user->phone ?? '-' }}
</p>

</div>



<!-- ROOM INFO -->
<div class="bg-white shadow rounded-lg p-6 mb-6">

<h2 class="text-xl font-semibold mb-4">
    Informasi Kamar
</h2>


@if($roomHistory)

<p>
    Nomor Kamar :
    <b>
        {{ $roomHistory->room->room_number }}
    </b>
</p>


<p>
    Harga Sewa :
    Rp {{ number_format($roomHistory->room->price) }}
</p>


<p>
    Mulai Tinggal :
    {{ $roomHistory->start_date }}
</p>


@else

<p>
    Belum memiliki kamar
</p>

@endif


</div>




<!-- TAGIHAN -->
<div class="bg-white shadow rounded-lg p-6 mb-6">


<h2 class="text-xl font-semibold mb-4">
    Tagihan Saat Ini
</h2>


@if($currentPayment)

<p>
    Nominal:
    <b>
    Rp {{ number_format($currentPayment->amount) }}
    </b>
</p>


<p>
Status:

@if($currentPayment->status == 'paid')

<span class="text-green-600">
Lunas
</span>

@elseif($currentPayment->status == 'pending')

<span class="text-yellow-600">
Menunggu Verifikasi
</span>

@else

<span class="text-red-600">
Belum Bayar
</span>

@endif


</p>


@else

<p>
Belum ada tagihan
</p>

@endif


</div>





<!-- PAYMENT HISTORY -->

<div class="bg-white shadow rounded-lg p-6">


<h2 class="text-xl font-semibold mb-4">
Riwayat Pembayaran
</h2>


<table class="w-full">

<thead>

<tr class="border-b">

<th class="text-left">
Tanggal
</th>

<th>
Nominal
</th>

<th>
Status
</th>

</tr>

</thead>


<tbody>


@foreach($payments as $payment)

<tr class="border-b">


<td>
{{ $payment->created_at->format('d M Y') }}
</td>


<td>
Rp {{ number_format($payment->amount) }}
</td>


<td>

{{ ucfirst($payment->status) }}

</td>


</tr>


@endforeach


</tbody>

</table>


</div>


</div>

@endsection