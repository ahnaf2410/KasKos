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

    <x-sidebar-user :active="$activePage ?? 'dashboard'" />

    <div class="flex-1 flex flex-col md:pl-64 min-h-screen transition-all duration-300">

        <header class="bg-white border-b border-slate-100 sticky top-0 z-30 h-16 flex items-center justify-between px-6 shadow-sm shadow-slate-100/50">

            <div class="flex items-center space-x-4 flex-1 max-w-md">
                <button id="sidebar-toggle" class="md:hidden p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-50 rounded-xl focus:outline-none transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

            </div>

            <div class="flex items-center space-x-4">

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
