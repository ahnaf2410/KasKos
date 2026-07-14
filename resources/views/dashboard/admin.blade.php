@extends('layouts.app', ['activePage' => 'dashboard'])

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500">Selamat datang di KasKos.</p>
        </div>
        <a href="#" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">+ Tambah Kamar</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        @php
        $cards=[
        ['Total Penghuni','18','👥','bg-blue-600'],
        ['Total Kamar','25','🏠','bg-green-600'],
        ['Tagihan Aktif','34','💳','bg-yellow-500'],
        ['Pendapatan','Rp15.5 Jt','💰','bg-red-600']];
        @endphp

        @foreach($cards as $c)
        <div class="bg-white rounded-2xl shadow p-5">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">{{ $c[0] }}</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $c[1] }}</h2>
                </div>
                <div class="{{ $c[3] }} w-14 h-14 rounded-xl flex items-center justify-center text-2xl text-white">
                    {{ $c[2] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-2xl shadow p-6">
            <div class="flex justify-between mb-4">
                <h2 class="font-bold text-xl">Aktivitas Pembayaran</h2>
                <button class="text-sm text-red-600">Lihat Semua</button>
            </div>

            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Penghuni</th>
                        <th class="p-3 text-left">Tagihan</th>
                        <th class="p-3 text-left">Nominal</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                @for($i=1;$i<=6;$i++)
                    <tr class="border-b">
                        <td class="p-3">Penghuni {{ $i }}</td>
                        <td class="p-3">Tagihan Bulanan</td>
                        <td class="p-3">Rp450.000</td>
                        <td class="p-3">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Lunas
                            </span>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow p-5">
                <h3 class="font-bold mb-3">Tagihan Belum Lunas</h3>
                <div class="space-y-3">
                    <div class="flex justify-between"><span>Air</span><span>Rp50.000</span></div>
                    <div class="flex justify-between"><span>Listrik</span><span>Rp120.000</span></div>
                    <div class="flex justify-between"><span>Internet</span><span>Rp100.000</span></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <h3 class="font-bold mb-3">Lokasi</h3>
                <div class="rounded-xl overflow-hidden h-56">
                    <iframe
                        src="https://www.google.com/maps?q=Universitas+Muhammadiyah+Bandung&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <h3 class="font-bold mb-4">Okupansi Kamar</h3>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-red-600 h-3 rounded-full" style="width:72%"></div>
                </div>
                <p class="mt-2 text-sm text-gray-600">18 dari 25 kamar terisi (72%)</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-bold">Penghuni Baru</h3>
            <p class="text-4xl font-bold mt-3">4</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-bold">Pembayaran Pending</h3>
            <p class="text-4xl font-bold mt-3">6</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-bold">Rooms History</h3>
            <p class="text-4xl font-bold mt-3">12</p>
        </div>
    </div>
</div>
@endsection
