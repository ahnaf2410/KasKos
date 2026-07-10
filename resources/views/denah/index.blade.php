<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-[#E84855] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 10.5 12 3l9 7.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 9.5V21h14V9.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Denah Kamar') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex flex-wrap items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-500"></span>
                    <span class="text-sm text-slate-600">Kosong</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-[#E84855]"></span>
                    <span class="text-sm text-slate-600">Terisi</span>
                </div>
                <span class="ml-auto text-xs text-slate-400 italic">Tampilan visual saja — klaim & pindah kamar belum tersedia di tahap ini.</span>
            </div>

            @forelse ($kamars as $lantai => $items)
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-4">
                        Lantai {{ $lantai }}
                    </h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach ($items as $kamar)
                            @php
                                // Disesuaikan dengan value di database kamu ('vacant' = kosong)
                                $isKosong = strtolower($kamar->status) === 'vacant';
                            @endphp

                            <div class="rounded-xl border-2 p-4 flex flex-col items-center justify-center text-center transition
                                {{ $isKosong
                                    ? 'bg-emerald-50 border-emerald-300'
                                    : 'bg-[#E84855]/10 border-[#E84855]/40' }}">

                                @if (!$isKosong)
                                    <div class="w-8 h-8 rounded-full bg-[#E84855] text-white flex items-center justify-center text-xs font-semibold mb-2">
                                        {{-- Menggunakan relasi tenant_id / atau fallback huruf 'T' jika relasi belum diset --}}
                                        {{ strtoupper(substr($kamar->penghuni->name ?? 'T', 0, 1)) }}
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-emerald-500/15 text-emerald-600 flex items-center justify-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Mengubah nomor_kamar menjadi room_number --}}
                                <span class="font-semibold text-sm {{ $isKosong ? 'text-emerald-700' : 'text-[#C3323E]' }}">
                                    {{ $kamar->room_number }}
                                </span>

                                <span class="text-xs mt-0.5 {{ $isKosong ? 'text-emerald-600' : 'text-[#C3323E]/80' }}">
                                    {{ $isKosong ? 'Kosong' : ($kamar->penghuni->name ?? 'Terisi') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-12 text-center text-slate-400">
                    <p class="text-sm">Belum ada data kamar.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
