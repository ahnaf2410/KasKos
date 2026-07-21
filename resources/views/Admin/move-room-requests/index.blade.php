@extends('layouts.app', ['activePage' => 'move-room-requests'])

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-100 rounded-xl text-red-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Permintaan Pindah Kamar</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola permintaan pindah kamar dari penghuni.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Penghuni</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Dari Kamar</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Ke Kamar</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Tanggal Request</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Status</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($requests as $req)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-rose-100 flex items-center justify-center text-xs font-bold text-rose-700">
                                    {{ strtoupper(substr($req->user?->name ?? '--', 0, 2)) }}
                                </div>
                                <span class="font-medium text-slate-800">{{ $req->user?->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-600 font-semibold">{{ $req->fromRoom?->room_number ?? '-' }}</td>
                        <td class="px-5 py-4 text-slate-600 font-semibold">{{ $req->toRoom?->room_number ?? '-' }}</td>
                        <td class="px-5 py-4 text-slate-500 text-xs">{{ $req->created_at->format('d M Y H:i') }}</td>
                        <td class="px-5 py-4">
                            @if($req->status == 'pending')
                                <span class="bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full text-xs font-medium">Pending</span>
                            @elseif($req->status == 'approved')
                                <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-medium">Disetujui</span>
                            @else
                                <span class="bg-red-50 text-red-700 px-2.5 py-1 rounded-full text-xs font-medium">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if($req->status == 'pending')
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.move-room-requests.approve', $req) }}" method="POST" onsubmit="return confirm('Setujui permintaan pindah kamar ini?')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.move-room-requests.reject', $req) }}" method="POST" onsubmit="return confirm('Tolak permintaan pindah kamar ini?')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition">Tolak</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-slate-400">
                                    {{ $req->approved_at ? $req->approved_at->format('d M Y') : '-' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-400">Belum ada permintaan pindah kamar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $requests->links() }}</div>
</div>
@endsection

