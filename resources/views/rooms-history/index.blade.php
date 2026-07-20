@extends('layouts.app', ['activePage' => 'room-history'])

@section('content')
<div class="min-h-screen bg-[#f8fafc] text-slate-800 p-6">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 flex items-center gap-3">
                    <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat Kamar (Room History)
                </h1>
                <p class="text-sm text-slate-500 mt-1">Pantau histori perpindahan, penghuni masuk, dan keluar kamar kos secara terpusat.</p>
            </div>
        </div>

        {{-- Form Filter & Pencarian --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.02)]">
            <form action="{{ route('admin.room-history.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                {{-- Input Cari Nama --}}
                <div class="space-y-1.5">
                    <label for="search" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Cari Penghuni</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama penghuni..."
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                </div>

                {{-- Dropdown Pilih Kamar --}}
                <div class="space-y-1.5">
                    <label for="room" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Kamar</label>
                    <select name="room" id="room" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        <option value="">Semua Kamar</option>
                        @foreach($rooms as $r)
                            <option value="{{ $r->id }}" {{ request('room') == $r->id ? 'selected' : '' }}>Kamar No. {{ $r->room_number }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Tanggal --}}
                <div class="space-y-1.5">
                    <label for="date" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Masuk</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                </div>

                {{-- Dropdown Status --}}
                <div class="space-y-1.5">
                    <label for="status" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status</label>
                    <select name="status" id="status" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif Menempati</option>
                        <option value="moved" {{ request('status') == 'moved' ? 'selected' : '' }}>Pindah Kamar</option>
                        <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Keluar / Selesai</option>
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white font-semibold text-sm rounded-xl py-2.5 shadow-md shadow-rose-500/10 hover:shadow-rose-500/20 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'room', 'date', 'status']))
                        <a href="{{ route('admin.room-history.index') }}" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-600 px-3 py-2.5 rounded-xl text-sm transition flex items-center justify-center" title="Reset Filter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18"></path></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-[0_2px_12px_rgba(0,0,0,0.01)]">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 border-b border-slate-200 uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-5 py-3.5 font-bold">Nama Penghuni</th>
                    <th class="px-5 py-3.5 font-bold">Nomor Kamar</th>
                    <th class="px-5 py-3.5 font-bold">Tanggal Masuk</th>
                    <th class="px-5 py-3.5 font-bold">Tanggal Keluar</th>
                    <th class="px-5 py-3.5 font-bold">Status Sewa</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($histories as $history)
                        <tr class="hover:bg-slate-50/60 transition bg-white text-slate-700">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-[#E84855]/10 text-[#C3323E] flex items-center justify-center text-xs font-semibold">
                                        {{ strtoupper(substr($history->user->name ?? '-', 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-slate-900">{{ $history->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-600 font-semibold">
                                {{ $history->room->room_number ?? '-' }}
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                {{ $history->start_date ? \Carbon\Carbon::parse($history->start_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                {{ $history->end_date ? \Carbon\Carbon::parse($history->end_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-4">
                                @php
                                    $statusStyle = match(strtolower($history->status)) {
                                        'active', 'occupied' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'pending'            => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'completed', 'vacant' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        default              => 'bg-rose-50 text-rose-700 border-rose-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusStyle }}">
                                    {{ ucfirst($history->status) }}
                                </span>
                            </td
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-400 bg-white">
                                <div class="flex flex-col items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round"/>
                                    </svg>
                                    <p class="text-sm font-medium">Belum ada data riwayat sewa.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        @if($histories->hasPages())
            <div class="bg-slate-50/50 border border-slate-200 rounded-xl px-6 py-4">
                {{ $histories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
