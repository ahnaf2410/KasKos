@extends('layouts.app', ['activePage' => 'dashboard'])

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500">Selamat datang di KasKos.</p>
        </div>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        @php
        $cards = [
            [
                'Total KasKos',
                'Rp ' . number_format($totalKasKos, 0, ',', '.'),
                '💰',
                'bg-emerald-600'
            ],
            [
                'Kamar Terisi',
                $kamarTerisi,
                '🏠',
                'bg-blue-600'
            ],
            [
                'Kamar Kosong',
                $kamarKosong,
                '🚪',
                'bg-orange-500'
            ],
            [
                'Verifikasi',
                $verifikasi,
                '✔️',
                'bg-red-600'
            ],
        ];
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
            </div>

    <!-- Aktivitas Pembayaran -->
    <div class="xl:col-span-2 bg-white rounded-2xl shadow p-6">

        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-xl">Aktivitas Pembayaran</h2>
        </div>

        <div class="overflow-x-auto">
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
                @forelse($recentPayments as $payment)
                <tr class="border-b">
                    <td class="p-3">{{ $payment->user->name }}</td>

                    <td class="p-3">
                        {{ optional($payment->bill)->title ?? '-' }}
                    </td>

                    <td class="p-3">
                        Rp {{ number_format($payment->split_amount,0,',','.') }}
                    </td>

                    <td class="p-3">
                        @if($payment->status == 'verified')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                Verified
                            </span>
                        @elseif($payment->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
                                Pending
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                Rejected
                            </span>
                        @endif
                    </td>
                </tr>

                @empty

                <tr>
                <td colspan="4" class="text-center py-8 text-gray-500">
                Belum ada data pembayaran
                </td>
                </tr>

                @endforelse
                </tbody>

            </table>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow p-5">
                <h3 class="font-bold mb-3">Tagihan Belum Lunas</h3>
                <div class="space-y-3">

                @forelse($unpaidBills as $bill)

                <div class="flex justify-between">
                    <span>
                        {{ $bill['title'] }}
                    </span>

                    <span>
                        Rp {{ number_format($bill['amount'],0,',','.') }}
                    </span>
                </div>

                @empty

                <p class="text-gray-500">
                    Tidak ada tagihan
                </p>

                @endforelse

                </div>

                    </div>
            </div>
        </div>

        <!-- Lokasi -->
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
                    <div 
                        class="bg-red-600 h-3 rounded-full"
                        style="width: {{ $occupancyPercentage }}%">
                        </div>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $kamarTerisi }} dari {{ $totalRooms }}
                    kamar terisi ({{ $occupancyPercentage }}%)
                </p>
        </div>
        </div>

    </div>

</div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-bold">Penghuni Baru</h3>
            <p class="text-4xl font-bold mt-3">
            {{ $newTenants }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-bold">Pembayaran Pending</h3>
            <p class="text-4xl font-bold mt-3">
            {{ $pendingPayments }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-bold">Rooms History</h3>
            <p class="text-4xl font-bold mt-3">
            {{ $roomsHistory }}
            </p>
        </div>
    </div>
</div>
@endsection
