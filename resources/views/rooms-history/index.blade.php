<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-[#E84855] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Riwayat Sewa Kamar') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-slate-100 rounded-2xl">
                <div class="p-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Log Riwayat Sewa</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Riwayat masa aktif sewa kamar penghuni yang tercatat di sistem.</p>
                        </div>

                        <form method="GET" action="{{ route('rooms-history.index') }}" class="w-full sm:w-72">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="M21 21l-4.3-4.3" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                       placeholder="Cari nama, kamar, atau status..."
                                       class="w-full rounded-lg border-slate-300 pl-9 pr-3 py-2 text-sm placeholder-slate-400 focus:border-[#E84855] focus:ring-[#E84855] focus:ring-1">
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-4 py-3 font-medium">Nama Penghuni</th>
                                    <th class="px-4 py-3 font-medium">Nomor Kamar</th>
                                    <th class="px-4 py-3 font-medium">Status Sewa</th>
                                    <th class="px-4 py-3 font-medium">Periode Kontrak</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($histories as $history)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-[#E84855]/10 text-[#C3323E] flex items-center justify-center text-xs font-semibold">
                                                    {{ strtoupper(substr($history->user->name ?? '-', 0, 1)) }}
                                                </div>
                                                <span class="font-medium text-slate-700">{{ $history->user->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600 font-semibold">
                                            {{-- FIXED: Diubah dari nomor_kamar ke room_number --}}
                                            {{ $history->room->room_number ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusStyle = match(strtolower($history->status)) {
                                                    'active', 'occupied' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                                    'pending'            => 'bg-amber-50 text-amber-600 border-amber-200',
                                                    'completed', 'vacant' => 'bg-slate-100 text-slate-500 border-slate-200',
                                                    default              => 'bg-red-50 text-red-600 border-red-200',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusStyle }}">
                                                {{ ucfirst($history->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600 text-xs">
                                            <span class="font-medium text-slate-700">
                                                {{ $history->created_at->format('d M Y H:i') }}
                                            </span>
                                            @if(strtolower($history->status) == 'active')
                                                <span class="text-emerald-500 font-medium"> (Mulai Menempati) </span>
                                            @else
                                                <span class="text-red-500 font-medium"> (Keluar/Pindah) </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-12 text-center text-slate-400">
                                            <div class="flex flex-col items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round"/>
                                                </svg>
                                                <p class="text-sm">Belum ada data riwayat sewa.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $histories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
