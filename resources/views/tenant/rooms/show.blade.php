@extends('layouts.tenant', ['activePage' => 'denah'])

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
    {{ session('error') }}
</div>
@endif

<div class="max-w-2xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Detail Kamar</h2>
            <a href="{{ route('tenant.rooms.index') }}" class="text-sm text-rose-600 hover:underline">&larr; Kembali</a>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between p-4 bg-slate-50 rounded-xl">
                <span class="font-medium text-slate-500">Nomor Kamar</span>
                <span class="font-bold text-slate-900">{{ $room->room_number }}</span>
            </div>

            <div class="flex justify-between p-4 bg-slate-50 rounded-xl">
                <span class="font-medium text-slate-500">Lantai</span>
                <span class="font-bold text-slate-900">{{ $room->floor }}</span>
            </div>

            <div class="flex justify-between p-4 bg-slate-50 rounded-xl">
                <span class="font-medium text-slate-500">Harga Sewa</span>
                <span class="font-bold text-slate-900">Rp {{ number_format($room->rental_price, 0, ',', '.') }}</span>
            </div>

            <div class="flex justify-between p-4 bg-slate-50 rounded-xl">
                <span class="font-medium text-slate-500">Status</span>
                <span class="font-bold text-slate-900">{{ ucfirst($room->status) }}</span>
            </div>

            @if($room->description)
            <div class="p-4 bg-slate-50 rounded-xl">
                <span class="font-medium text-slate-500 block mb-1">Deskripsi</span>
                <span class="text-slate-700">{{ $room->description }}</span>
            </div>
            @endif
        </div>

        @php
            $user = auth()->user();
            $myRoom = \App\Models\Room::where('tenant_id', $user->id)->first();
        @endphp

        @if($room->status == 'vacant' && !$myRoom)
        {{-- Belum punya kamar, kamar ini kosong -> BISA PILIH --}}
        <form action="{{ route('tenant.rooms.select', $room) }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="w-full py-3 bg-[#00695C] hover:bg-[#004D40] text-white font-bold text-sm rounded-xl transition shadow-sm">
                Pilih Kamar Ini
            </button>
        </form>
        @elseif($room->status == 'vacant' && $myRoom && $myRoom->id !== $room->id)
        {{-- Sudah punya kamar, kamar ini kosong -> BISA MINTA PINDAH --}}
        <form action="{{ route('tenant.rooms.request-move', $room) }}" method="POST" class="mt-6">
            @csrf
            <div class="mb-3">
                <textarea name="notes" rows="2" class="w-full rounded-xl border-gray-300 text-sm" placeholder="Alasan pindah (opsional)"></textarea>
            </div>
            <button type="submit" class="w-full py-3 bg-[#5C6BC0] hover:bg-[#3F51B5] text-white font-bold text-sm rounded-xl transition shadow-sm">
                Minta Pindah ke Kamar Ini
            </button>
            <p class="text-xs text-gray-500 text-center mt-2">Admin akan memverifikasi permintaan Anda.</p>
        </form>
        @elseif($room->status == 'occupied')
        <div class="mt-6 p-4 bg-rose-50 rounded-xl text-center">
            <p class="text-rose-700 font-medium">Kamar ini sudah ditempati oleh penyewa lain.</p>
        </div>
        @endif
    </div>

</div>
@endsection
