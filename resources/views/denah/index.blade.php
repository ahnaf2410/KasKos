@extends('layouts.app', ['activePage' => 'denah'])

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Denah Visual Kamar</h2>
            <p class="text-xs text-slate-400 mt-1">Pantau ketersediaan slot kamar kos secara real-time grid.</p>
        </div>

        <div class="flex flex-wrap items-center gap-4 bg-white px-4 py-2.5 rounded-xl border border-slate-100 text-xs font-semibold shadow-sm">
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 block"></span>
                <span class="text-slate-600">Kosong (Tersedia)</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full bg-indigo-500 block"></span>
                <span class="text-slate-600">Menunggu Verifikasi</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full bg-rose-500 block"></span>
                <span class="text-slate-600">Terisi (Aktif)</span>
            </div>
        </div>
    </div>

    {{-- Stats Cards Dinamis --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-slate-50 text-slate-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 tracking-wider block uppercase">Total Kamar</span>
                <span class="text-lg font-bold text-slate-800">{{ $totalRooms }} Kamar</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 tracking-wider block uppercase">Tersedia</span>
                <span class="text-lg font-bold text-slate-800">{{ $availableRooms }} Slot</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 tracking-wider block uppercase">Pending</span>
                <span class="text-lg font-bold text-slate-800">{{ $pendingRooms }} Kamar</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 tracking-wider block uppercase">Terisi</span>
                <span class="text-lg font-bold text-slate-800">{{ $occupiedRooms }} Kamar</span>
            </div>
        </div>
    </div>

    {{-- Filter Navigasi Lantai Dinamis --}}
    <div class="border-b border-slate-200 flex space-x-6 text-sm font-semibold">
        <a href="{{ url()->current() }}" class="border-b-2 {{ request('floor') == null ? 'border-rose-500 text-rose-600' : 'border-transparent text-slate-400 hover:text-slate-600' }} pb-3 px-1 transition">Semua Lantai</a>
        <a href="{{ url()->current() . '?floor=1' }}" class="border-b-2 {{ request('floor') == '1' ? 'border-rose-500 text-rose-600' : 'border-transparent text-slate-400 hover:text-slate-600' }} pb-3 px-1 transition">Lantai 1</a>
        <a href="{{ url()->current() . '?floor=2' }}" class="border-b-2 {{ request('floor') == '2' ? 'border-rose-500 text-rose-600' : 'border-transparent text-slate-400 hover:text-slate-600' }} pb-3 px-1 transition">Lantai 2</a>
        <a href="{{ url()->current() . '?floor=3' }}" class="border-b-2 {{ request('floor') == '3' ? 'border-rose-500 text-rose-600' : 'border-transparent text-slate-400 hover:text-slate-600' }} pb-3 px-1 transition">Lantai 3</a>
    </div>

    {{-- Grid Kamar Murni dari Database --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">

        @forelse ($rooms as $room)
            @php
                // Menyamakan format string status (lowercase)
                $status = strtolower($room->status);

                // Set warna border, badge, dan label berdasarkan status di DB
                $style = match($status) {
                    'occupied', 'terisi'  => ['border' => 'border-rose-500', 'badge' => 'bg-rose-50 text-rose-600', 'label' => 'Terisi'],
                    'pending'             => ['border' => 'border-indigo-500', 'badge' => 'bg-indigo-50 text-indigo-600', 'label' => 'Pending'],
                    default               => ['border' => 'border-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-600', 'label' => 'Kosong'],
                };

                // Mengambil nama penyewa dari relasi model (sesuaikan nama relasi kamu: tenant/user)
                $tenantName = $room->tenant->name ?? ($room->user->name ?? 'Tanpa Nama');
            @endphp

            <div class="bg-white rounded-2xl border-2 {{ $style['border'] }} shadow-sm p-4 relative flex flex-col justify-between h-36 hover:shadow-md transition">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-base font-bold text-slate-900">{{ $room->room_number }}</span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $style['badge'] }} uppercase">{{ $style['label'] }}</span>
                    </div>

                    @if(in_array($status, ['occupied', 'terisi', 'pending']))
                        <p class="text-xs font-semibold text-slate-700 mt-2 truncate">{{ $tenantName }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $room->room_type ?? 'Standard Room' }}</p>
                    @else
                        <p class="text-xs font-medium italic text-slate-400 mt-2">Belum ada penghuni</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $room->room_type ?? 'Standard Room' }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-between border-t border-slate-50 pt-2 mt-2">
                    @if(in_array($status, ['occupied', 'terisi']))
                        <span class="text-[10px] font-bold text-slate-400">Jatuh Tempo:</span>
                        <span class="text-[11px] font-bold text-rose-600">
                            {{ $room->due_date ? \Carbon\Carbon::parse($room->due_date)->translatedFormat('d M Y') : '-' }}
                        </span>
                    @elseif($status == 'pending')
                        <span class="text-[10px] font-bold text-slate-400">Aksi:</span>
                        <a href="#" class="text-[10px] font-bold text-indigo-600 hover:underline">Cek Bukti TF →</a>
                    @else
                        <span class="text-[10px] font-bold text-slate-400">Harga Sewa:</span>
                        <span class="text-[11px] font-bold text-slate-700">Rp {{ number_format($room->price ?? 0, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-xl border border-dashed border-slate-200">
                Belum ada data kamar untuk kategori lantai ini.
            </div>
        @endforelse

    </div>
</div>
@endsection
