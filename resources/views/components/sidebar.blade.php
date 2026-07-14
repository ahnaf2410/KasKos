@props(['active' => 'denah'])

<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-[#1e293b] text-white flex flex-col justify-between z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-700">

    <div class="flex flex-col flex-1 overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-700">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-rose-500 text-white shadow-md shadow-rose-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight tracking-wide">SobatKos</h1>
                    <span class="text-xs text-slate-400 font-medium">Kos Management</span>
                </div>
            </div>
            <button id="sidebar-close" class="md:hidden text-slate-400 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5">
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $active == 'dashboard' ? 'bg-rose-500 text-white font-semibold shadow-md shadow-rose-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                <span class="text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.denah.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $active == 'denah' ? 'bg-rose-500 text-white font-semibold shadow-md shadow-rose-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                <span class="text-sm">Denah Kamar</span>
            </a>

            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $active == 'kamar' ? 'bg-rose-500 text-white font-semibold shadow-md shadow-rose-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-sm">Data Kamar</span>
            </a>

            <a href="{{ route('admin.bill-categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $active == 'kategori-tagihan' ? 'bg-rose-500 text-white font-semibold shadow-md shadow-rose-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span class="text-sm">Kategori Tagihan</span>
            </a>

            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $active == 'tagihan' ? 'bg-rose-500 text-white font-semibold shadow-md shadow-rose-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="text-sm">Tagihan Bulanan</span>
            </a>

            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $active == 'pembayaran' ? 'bg-rose-500 text-white font-semibold shadow-md shadow-rose-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="text-sm">Verifikasi Pembayaran</span>
            </a>

            <div class="pt-4 pb-2 px-4">
                <p class="text-[10px] font-bold tracking-wider text-slate-500 uppercase">Akun Pengguna</p>
            </div>

            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $active == 'profile' ? 'bg-rose-500 text-white font-semibold shadow-md shadow-rose-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-sm">Profil Saya</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-slate-700 bg-slate-900/50">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-slate-600 flex items-center justify-center text-sm font-bold text-white uppercase">
                    {{ substr(Auth::user()->name ?? 'Admin', 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Owner SobatKos' }}</p>
                    <p class="text-xs text-slate-400 truncate">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') ?? '#' }}">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-rose-400 p-1.5 rounded-lg hover:bg-slate-800 transition focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </div>
</aside>
