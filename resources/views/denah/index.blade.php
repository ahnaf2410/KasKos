@extends('layouts.app', ['activePage' => 'denah'])

@section('content')
<div class="min-h-screen bg-[#F8FAFC] p-6 text-slate-800">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header & Status Legend --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-950 tracking-tight">Interactive Floor Plan</h1>
                <p class="text-sm text-slate-500 mt-0.5">Real-time room occupancy and management grid</p>
            </div>

            <div class="flex items-center gap-4 bg-white px-4 py-2 rounded-xl border border-slate-100 shadow-sm text-xs font-semibold">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#00695C]"></span>
                    <span class="text-slate-600">Available</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#5C6BC0]"></span>
                    <span class="text-slate-600">Pending</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#801824]"></span>
                    <span class="text-slate-600">Occupied</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full border-2 border-yellow-400 bg-transparent"></span>
                    <span class="text-slate-600">Kamar Saya</span>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-rose-50 text-[#801824] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Kamar</span>
                    <span class="text-xl font-extrabold text-slate-900">{{ $totalRooms }}</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-emerald-50 text-[#00695C] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tersedia</span>
                    <span class="text-xl font-extrabold text-slate-900">{{ $availableRooms }}</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-indigo-50 text-[#5C6BC0] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pending</span>
                    <span class="text-xl font-extrabold text-slate-900">{{ $pendingRooms }}</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-rose-50 text-[#801824] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Terisi</span>
                    <span class="text-xl font-extrabold text-slate-900">{{ $occupiedRooms }}</span>
                </div>
            </div>
        </div>

        {{-- Filter Navigasi Lantai (hanya sampai Lantai 3) --}}
        <div class="inline-flex bg-slate-200/70 p-1 rounded-xl text-xs font-bold shadow-inner">
            <a href="{{ url()->current() }}" class="px-4 py-2 rounded-lg transition {{ request('floor') == null ? 'bg-white text-[#801824] shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">Semua Lantai</a>
            <a href="{{ route('admin.denah.index', ['floor' => 1]) }}" class="px-4 py-2 rounded-lg transition {{ request('floor') == '1' ? 'bg-white text-[#801824] shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">Lantai 1</a>
            <a href="{{ route('admin.denah.index', ['floor' => 2]) }}" class="px-4 py-2 rounded-lg transition {{ request('floor') == '2' ? 'bg-white text-[#801824] shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">Lantai 2</a>
            <a href="{{ route('admin.denah.index', ['floor' => 3]) }}" class="px-4 py-2 rounded-lg transition {{ request('floor') == '3' ? 'bg-white text-[#801824] shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">Lantai 3</a>
        </div>

        {{-- Grid Kamar --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse ($rooms as $room)
                @php
                    $status = strtolower($room->status);
                    $tenantName = $room->tenant->name ?? 'User';
                    $initials = strtoupper(substr($tenantName, 0, 2));
                @endphp

                @if(in_array($status, ['occupied', 'terisi']))
                    @php
                        $isCurrentUser = auth()->id() && $room->tenant_id === auth()->id();
                    @endphp
                    <div class="bg-[#801824] text-white rounded-2xl p-4 flex flex-col justify-between items-center text-center h-44 shadow-sm hover:scale-[1.02] transition duration-200 {{ $isCurrentUser ? 'ring-4 ring-yellow-400 ring-offset-2' : '' }}">
                        <span class="text-[10px] font-bold tracking-wider opacity-60 uppercase">Room</span>
                        <h3 class="text-xl font-extrabold -mt-1">{{ $room->room_number }}</h3>
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center font-bold text-sm tracking-wide my-1">{{ $initials }}</div>
                        <span class="text-[10px] font-bold tracking-wider opacity-75 uppercase">OCCUPIED</span>
                    </div>
                @elseif(in_array($status, ['pending', 'waiting']))
                    <div class="bg-[#5C6BC0] text-white rounded-2xl p-4 flex flex-col justify-between items-center text-center h-44 shadow-sm hover:scale-[1.02] transition duration-200">
                        <span class="text-[10px] font-bold tracking-wider opacity-60 uppercase">Room</span>
                        <h3 class="text-xl font-extrabold -mt-1">{{ $room->room_number }}</h3>
                        <div class="my-2 animate-spin duration-1000">
                            <svg class="w-6 h-6 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold tracking-wider opacity-75 uppercase">PENDING REVIEW</span>
                    </div>
                @else
                    <div class="bg-white border border-slate-100 text-slate-800 rounded-2xl p-4 flex flex-col justify-between items-center text-center h-44 shadow-sm hover:scale-[1.02] transition duration-200">
                        <span class="absolute top-3 right-3 w-2 h-2 rounded-full bg-[#00695C]"></span>
                        <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">Room</span>
                        <h3 class="text-xl font-extrabold text-slate-900 -mt-1">{{ $room->room_number }}</h3>
                        <a href="#" class="w-full py-2 bg-[#00695C] hover:bg-[#004D40] text-white font-bold text-xs rounded-xl transition shadow-sm tracking-wide">KLAIM</a>
                        <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">Rp {{ number_format($room->rental_price ?? 0, 0, ',', '.') }}</span>
                    </div>
                @endif
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-2xl border border-dashed border-slate-200">
                    Belum ada data kamar pada kategori lantai ini.
                </div>
            @endforelse
        </div>

        {{-- Recent Activity Log --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm max-w-2xl">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3">Recent Activity</h3>
            <div class="mt-4 space-y-4">
                @forelse($roomHistories ?? [] as $history)
                    <div class="flex items-start gap-3 text-xs">
                        @php
                            $histStatus = strtolower($history->status);
                            $iconColor = match($histStatus) {
                                'occupied', 'terisi', 'claimed' => 'bg-emerald-50 text-emerald-600',
                                'pending' => 'bg-indigo-50 text-indigo-600',
                                default => 'bg-slate-50 text-slate-600',
                            };
                        @endphp
                        <div class="p-2 {{ $iconColor }} rounded-xl flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="space-y-0.5">
                            <p class="font-bold text-slate-800">
                                Kamar {{ $history->room->room_number ?? '-' }}
                                {{ $histStatus == 'pending' ? 'Sedang Di-Review' : 'Berhasil Diklaim' }}
                            </p>
                            <p class="text-[11px] text-slate-400 font-medium">
                                oleh {{ $history->user->name ?? 'Penyewa' }} • {{ $history->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs italic text-slate-400 py-4 text-center">Belum ada aktivitas transaksi terbaru.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
