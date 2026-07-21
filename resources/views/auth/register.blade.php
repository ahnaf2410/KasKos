<?php
/**
 * @var \Illuminate\Support\ViewErrorBag $errors
 * @var \Illuminate\View\View $this
 */
?>
<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-100 p-8">

        <!-- Logo Icon -->
        <div class="flex justify-center">
            <div class="w-14 h-14 rounded-xl bg-[#E84855] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 21V7a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M14 21V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v17" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 9h1M7 12h1M7 15h1M10 9h1M10 12h1M10 15h1M17 6h1M17 9h1M17 12h1M17 15h1" stroke-linecap="round"/>
                    <path d="M4 21h16" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="mt-4 text-center text-2xl font-bold text-[#C3323E]">KasKos</h1>
        <p class="mt-1 text-center text-sm text-slate-500">Buat akun baru untuk mulai mengelola kos.</p>

        <!-- Banner Image -->
        <div class="mt-5 rounded-xl overflow-hidden h-32">
            <img src="{{ asset('images/login-banner.jpg') }}" alt="KasKos" class="w-full h-full object-cover">
        </div>

        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-sm font-medium text-slate-700" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           autocomplete="name" placeholder="Nama lengkap anda"
                           class="block w-full rounded-lg border-slate-300 pl-10 pr-3 py-2.5 text-sm placeholder-slate-400 focus:border-[#E84855] focus:ring-[#E84855] focus:ring-1" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Username')" class="text-sm font-medium text-slate-700" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                           autocomplete="username" placeholder="manager_jdoe"
                           class="block w-full rounded-lg border-slate-300 pl-10 pr-3 py-2.5 text-sm placeholder-slate-400 focus:border-[#E84855] focus:ring-[#E84855] focus:ring-1" />
                </div>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Password -->
            <div x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="5" y="11" width="14" height="9" rx="2"/>
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required
                           autocomplete="new-password" placeholder="Minimal 8 karakter"
                           class="block w-full rounded-lg border-slate-300 pl-10 pr-10 py-2.5 text-sm placeholder-slate-400 focus:border-[#E84855] focus:ring-[#E84855] focus:ring-1" />
                    <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div x-data="{ show2: false }">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-sm font-medium text-slate-700" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="5" y="11" width="14" height="9" rx="2"/>
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input :type="show2 ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                           autocomplete="new-password" placeholder="Ulangi password"
                           class="block w-full rounded-lg border-slate-300 pl-10 pr-10 py-2.5 text-sm placeholder-slate-400 focus:border-[#E84855] focus:ring-[#E84855] focus:ring-1" />
                    <button type="button" @click="show2 = !show2"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Register Button -->
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 rounded-lg bg-[#C3323E] py-3 text-sm font-semibold text-white hover:bg-[#a82833] transition">
                {{ __('Daftar') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14" stroke-linecap="round"/>
                    <line x1="23" y1="11" x2="17" y2="11" stroke-linecap="round"/>
                </svg>
            </button>

            <!-- Login Link -->
            <p class="text-center text-sm text-slate-600 pt-1">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-[#C3323E] hover:underline">Masuk Sekarang</a>
            </p>
        </form>
    </div>
</x-guest-layout>
