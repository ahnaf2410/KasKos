<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-[#E84855] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 21V7a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M14 21V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v17" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 9h1M7 12h1M7 15h1M10 9h1M10 12h1M10 15h1M17 6h1M17 9h1M17 12h1M17 15h1" stroke-linecap="round"/>
                    <path d="M4 21h16" stroke-linecap="round"/>
                </svg>
            </div>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-slate-100 rounded-2xl">
                <div class="px-6 py-24 flex flex-col items-center justify-center text-center">

                    <!-- Icon -->
                    <div class="w-16 h-16 rounded-2xl bg-[#E84855]/10 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#E84855]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-[#C3323E]">Coming Soon</h3>
                    <p class="mt-2 text-sm text-slate-500 max-w-sm">
                        Kamu sudah berhasil login, {{ __("You're logged in!") }} Halaman dashboard KasKos masih dalam pengembangan.
                    </p>

                    <span class="mt-5 inline-flex items-center gap-1.5 rounded-full bg-amber-50 border border-amber-200 px-3 py-1 text-xs font-medium text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 8v4l3 3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Sedang dikembangkan
                    </span>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
