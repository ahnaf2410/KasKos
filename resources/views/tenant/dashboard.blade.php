@extends('layouts.tenant', ['activePage' => 'dashboard'])

@section('content')

<div class="p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Dashboard Tenant
        </h1>

        <p class="text-gray-500">
            Selamat datang, {{ auth()->user()->name }}. Berikut informasi kamar dan tagihan kamu.
        </p>
    </div>



    <!-- Cards -->

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

        @php
        $cards = [
            [
                'Tagihan Bulan Ini',
                'Rp ' . number_format($totalBill,0,',','.'),
                '💰',
                'bg-red-600'
            ],
            [
                'Status Pembayaran',
                $unpaid > 0 ? 'Belum Lunas' : 'Lunas',
                '💳',
                $unpaid > 0 ? 'bg-red-600' : 'bg-emerald-600'
            ],
            [
                'Kamar',
                $room->name ?? '-',
                '🏠',
                'bg-blue-600'
            ],
            [
                'Pembayaran',
                $payments->count(),
                '✔️',
                'bg-orange-500'
            ],
        ];
        @endphp


        @foreach($cards as $c)

        <div class="bg-white rounded-2xl shadow p-5">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        {{ $c[0] }}
                    </p>


                    <h2 class="text-2xl font-bold mt-2">
                        {{ $c[1] }}
                    </h2>

                </div>


                <div class="{{ $c[3] }} w-14 h-14 rounded-xl flex items-center justify-center text-2xl text-white">

                    {{ $c[2] }}

                </div>

            </div>

        </div>


        @endforeach

    </div>




    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


        <!-- Tagihan -->

        <div class="xl:col-span-2 bg-white rounded-2xl shadow p-6">


            <div class="flex justify-between mb-4">

                <h2 class="font-bold text-xl">
                    Tagihan Aktif
                </h2>

            </div>



            <table class="w-full">


                <thead class="bg-gray-100">

                    <tr>

                        <th class="p-3 text-left">
                            Tagihan
                        </th>

                        <th class="p-3 text-left">
                            Nominal
                        </th>

                        <th class="p-3 text-left">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>


                @forelse($bills as $bill)


                <tr class="border-b">


                    <td class="p-3">
                        {{ $bill['title'] }}
                    </td>


                    <td class="p-3">

                        Rp {{ number_format($bill['amount'],0,',','.') }}

                    </td>


                    <td class="p-3">


                        @if($bill['status']=='lunas')

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                            Lunas
                        </span>


                        @else


                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                            Belum Bayar
                        </span>


                        @endif


                    </td>


                </tr>


                @empty

                <tr>

                    <td colspan="3" class="text-center py-8 text-gray-500">

                        Belum ada tagihan

                    </td>

                </tr>

                @endforelse


                </tbody>


            </table>


        </div>




        <!-- Side -->

        <div class="space-y-6">


            <!-- Kamar -->

            <div class="bg-white rounded-2xl shadow p-5">


                <h3 class="font-bold mb-4">
                    Informasi Kamar
                </h3>


                <p class="text-gray-500">
                    Nomor Kamar
                </p>


                <p class="text-3xl font-bold">
                    {{ $room->name ?? '-' }}
                </p>


            </div>





            <!-- Aktivitas -->

            <div class="bg-white rounded-2xl shadow p-5">


                <h3 class="font-bold mb-4">
                    Aktivitas Pembayaran
                </h3>


                @forelse($payments as $payment)


                <div class="border-b py-3">


                    <p class="font-semibold">
                        Pembayaran
                    </p>


                    <p class="text-sm text-gray-500">

                        Rp {{ number_format($payment->amount,0,',','.') }}

                    </p>


                </div>


                @empty

                <p class="text-gray-500">
                    Belum ada aktivitas
                </p>

                @endforelse


            </div>


        </div>


    </div>




</div>

@endsection
