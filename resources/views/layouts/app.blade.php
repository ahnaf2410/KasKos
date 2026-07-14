<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SobatKos Management') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 min-h-screen antialiased flex">

    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 z-40 hidden md:hidden transition-opacity duration-300"></div>

    <x-sidebar :active="$activePage ?? 'denah'" />

    <div class="flex-1 flex flex-col md:pl-64 min-h-screen transition-all duration-300">

        <header class="bg-white border-b border-slate-100 sticky top-0 z-30 h-16 flex items-center justify-between px-6 shadow-sm shadow-slate-100/50">

            <div class="flex items-center space-x-4 flex-1 max-w-md">
                <button id="sidebar-toggle" class="md:hidden p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-50 rounded-xl focus:outline-none transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="relative w-full hidden sm:block">
                    <form action="{{ request()->url() }}" method="GET" class="relative w-full hidden sm:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder ?? 'Cari nomor kamar, nama penghuni...' }}" class="w-full pl-10 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-700 focus:outline-none focus:border-rose-300 focus:ring-4 focus:ring-rose-500/5 transition duration-200">
                    </form>
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-2.5 right-2.5 block h-2 w-2 rounded-full ring-2 ring-white bg-rose-500"></span>
                </button>

                <span class="h-6 w-px bg-slate-200 hidden sm:block"></span>

                <div class="flex items-center space-x-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-slate-900 leading-none">Gedung Utama A</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">3 Lantai • 24 Kamar</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 md:p-8">
            @yield('content')
        </main>

    </div>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const closeBtn = document.getElementById('sidebar-close');

        function toggleSidebarMobile() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebarMobile);
        if(closeBtn) closeBtn.addEventListener('click', toggleSidebarMobile);
        if(overlay) overlay.addEventListener('click', toggleSidebarMobile);
    </script>
</body>
</html>
