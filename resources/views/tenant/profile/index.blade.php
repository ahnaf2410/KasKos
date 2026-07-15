@extends('layouts.tenant', ['activePage' => 'profile'])

@section('content')
<div class="min-h-screen bg-[#F8FAFC] text-slate-800 p-6">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#801824]">Profil Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi akun Anda di SobatKos.</p>
        </div>

        {{-- Alert Status Sukses --}}
        @if (session('status') === 'profile-updated')
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Profil berhasil diperbarui!
            </div>
        @endif

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kiri: Ringkasan Profil Singkat --}}
            <div class="space-y-6">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex flex-col items-center text-center">
                    {{-- Avatar Placeholder (Menggunakan Inisial Nama) --}}
                    <div class="w-28 h-28 mb-4 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center shadow-inner">
                        <span class="text-3xl font-bold text-[#801824] uppercase">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </span>
                    </div>

                    <h2 class="text-lg font-bold text-slate-900">{{ auth()->user()->name }}</h2>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">@ {{ auth()->user()->username }}</p>

                    <div class="w-full border-t border-slate-100 my-4"></div>

                    {{-- Detail Akun --}}
                    <div class="w-full space-y-3.5 text-left text-sm">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-rose-50 rounded-lg text-[#801824]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Pengguna</p>
                                <p class="font-medium text-slate-700">{{ auth()->user()->username }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-rose-50 rounded-lg text-[#801824]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Akun</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200 mt-0.5">
                                    AKTIF
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Form Edit Data --}}
            <div class="lg:col-span-2">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <h3 class="text-base font-bold text-slate-900">Edit Profil</h3>
                            <p class="text-xs text-slate-500">Perbarui data autentikasi akun Anda secara berkala.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#801824] focus:ring-1 focus:ring-[#801824] transition">
                                @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700">Username</label>
                                <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#801824] focus:ring-1 focus:ring-[#801824] transition">
                                @error('username') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="border-t border-slate-100 my-6"></div>

                        {{-- Section Ubah Password --}}
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ubah Kata Sandi</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-700">Kata Sandi Baru</label>
                                    <input type="password" name="password" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#801824] focus:ring-1 focus:ring-[#801824] transition">
                                    @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-700">Konfirmasi Kata Sandi</label>
                                    <input type="password" name="password_confirmation" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-[#801824] focus:ring-1 focus:ring-[#801824] transition">
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-400">ⓘ Kosongkan jika tidak ingin mengubah kata sandi. Gunakan minimal 8 karakter.</p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-xl transition">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-[#801824] hover:bg-[#66121C] text-white font-semibold text-sm rounded-xl shadow-sm transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Bantuan & Keamanan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                <div class="p-2.5 bg-rose-50 text-[#801824] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Butuh Bantuan?</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Hubungi admin jika Anda mengalami kesulitan atau kendala mengenai akun.</p>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                <div class="p-2.5 bg-rose-50 text-[#801824] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Keamanan Data</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Data kredensial Anda enkripsi tingkat tinggi langsung di dalam database server.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
