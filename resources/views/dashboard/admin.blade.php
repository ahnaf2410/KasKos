@extends('layouts.app', ['activePage' => 'dashboard'])

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Admin</h1>
            <p class="text-sm text-slate-500 mt-0.5">Ringkasan data kos dan keuangan terkini.</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-medium text-slate-400">{{ now()->format('d F Y') }}</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total KasKos</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">Rp {{ number_format($totalKasKos, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kamar Terisi</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $kamarTerisi }} <span class="text-sm font-normal text-slate-400">/ {{ $totalRooms }}</span></p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kamar Kosong</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $kamarKosong }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $verifikasi }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart & Stats Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Occupancy Chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-slate-900">📊 Keterisian Kamar per Lantai</h2>
                <span class="text-xs font-medium text-slate-400">{{ $occupancyPercentage }}% terisi</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <canvas id="occupancyChart" height="180"></canvas>
                </div>
                <div class="space-y-2">
                    @foreach($floors as $floor)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <span class="text-sm font-semibold text-slate-700">{{ $floor['floor'] }}</span>
                        <div class="flex items-center gap-3 text-xs">
                            <span class="text-emerald-600 font-medium">🟢 {{ $floor['terisi'] }}</span>
                            <span class="text-orange-500 font-medium">🟠 {{ $floor['kosong'] }}</span>
                            <span class="text-slate-500">{{ $floor['total'] }}</span>
                        </div>
                    </div>
                    @endforeach
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg font-semibold">
                        <span class="text-sm text-blue-700">Total</span>
                        <div class="flex items-center gap-3 text-xs">
                            <span class="text-emerald-700">🟢 {{ $kamarTerisi }}</span>
                            <span class="text-orange-600">🟠 {{ $kamarKosong }}</span>
                            <span class="text-blue-700">{{ $totalRooms }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Unpaid Bills Sidebar --}}
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Tagihan Perlu Ditagih
            </h3>
            <div class="space-y-2 max-h-[300px] overflow-y-auto">
                @forelse($unpaidBills as $bill)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-800 truncate">{{ $bill->title }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[10px] font-medium {{ $bill->status == 'Belum Lunas' ? 'text-red-500' : 'text-amber-500' }}">{{ $bill->status }}</span>
                            <span class="text-[10px] text-slate-400">•</span>
                            <span class="text-[10px] text-slate-400">{{ $bill->type }}</span>
                            @if(isset($bill->user_name))
                            <span class="text-[10px] text-slate-400">• {{ $bill->user_name }}</span>
                            @endif
                        </div>
                    </div>
                    <span class="text-sm font-bold text-slate-800 ml-2">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-6">✅ Semua tagihan sudah lunas</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Payments & Location Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Payments Table --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-900">Aktivitas Pembayaran Terbaru</h2>
                <a href="{{ route('admin.payments.index') }}" class="text-xs font-semibold text-rose-600 hover:text-rose-700">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left">
                            <th class="px-5 py-3 font-semibold text-slate-500 text-xs uppercase">Penghuni</th>
                            <th class="px-5 py-3 font-semibold text-slate-500 text-xs uppercase">Tagihan</th>
                            <th class="px-5 py-3 font-semibold text-slate-500 text-xs uppercase">Nominal</th>
                            <th class="px-5 py-3 font-semibold text-slate-500 text-xs uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentPayments as $payment)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-xs font-bold text-rose-700">
                                        {{ strtoupper(substr($payment->user->name ?? '--', 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-slate-800">{{ $payment->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $payment->title ?? '-' }}</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5">
                                @if($payment->status == 'paid')
                                <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-medium">Lunas</span>
                                @elseif($payment->status == 'pending_verification')
                                <span class="bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full text-xs font-medium">Pending</span>
                                @else
                                <span class="bg-red-50 text-red-700 px-2.5 py-1 rounded-full text-xs font-medium">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-400">Belum ada aktivitas pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sidebar Widgets --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-3">📍 Lokasi</h3>
                <div class="rounded-lg overflow-hidden h-48">
                    <iframe src="https://www.google.com/maps?q=Universitas+Muhammadiyah+Bandung&output=embed" width="100%" height="100%" style="border:0;" loading="lazy"></iframe>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-3">📈 Okupansi Kamar</h3>
                <div class="w-full bg-slate-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-emerald-500 h-3 rounded-full transition-all" style="width: {{ $occupancyPercentage }}%"></div>
                </div>
                <p class="mt-2 text-xs text-slate-500 text-center font-medium">{{ $kamarTerisi }} dari {{ $totalRooms }} kamar terisi ({{ $occupancyPercentage }}%)</p>
            </div>
        </div>
    </div>

    {{-- Bottom Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400">Penghuni Baru</p>
                    <p class="text-lg font-bold text-slate-900">{{ $newTenants }}</p>
                    <p class="text-[10px] text-slate-400">Bulan ini</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400">Menunggu Verifikasi</p>
                    <p class="text-lg font-bold text-slate-900">{{ $pendingPayments }}</p>
                    <p class="text-[10px] text-slate-400">Pembayaran pending</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400">Room History</p>
                    <p class="text-lg font-bold text-slate-900">{{ $roomsHistory }}</p>
                    <p class="text-[10px] text-slate-400">Total riwayat</p>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('occupancyChart')?.getContext('2d');
    if (!ctx) return;
    const floors = @json($floors);
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: floors.map(f => f.floor.replace('Lantai ', 'L')),
            datasets: [
                {
                    label: 'Terisi',
                    data: floors.map(f => f.terisi),
                    backgroundColor: '#10b981',
                    borderRadius: 4,
                    barPercentage: 0.4,
                },
                {
                    label: 'Kosong',
                    data: floors.map(f => f.kosong),
                    backgroundColor: '#f97316',
                    borderRadius: 4,
                    barPercentage: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top', labels: { boxWidth: 12, padding: 8, font: { size: 11 } } } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } } },
                x: { ticks: { font: { size: 11 } } }
            }
        }
    });
});
</script>
@endsection

