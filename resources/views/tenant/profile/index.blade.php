@extends('layouts.app', ['activePage' => 'profile'])

@section('content')
<div class="min-h-screen bg-[#F8FAFC] text-slate-800 p-6">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#801824]">Profil Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi akun dan detail keanggotaan Anda di SobatKos.</p>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kiri: Avatar & Info Kamar --}}
            <div class="space-y-6">
                {{-- Card 1: Ringkasan Profil --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex flex-col items-center text-center">
                    {{-- Avatar Wrapper --}}
                    <div class="relative w-32 h-32 mb-4">
                        <div class="w-full h-full rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        {{-- Floating Edit Icon --}}
                        <label for="avatar-input" class="absolute bottom-1 right-1 bg-[#801824] hover:bg-[#66121C] text-white p-2 rounded-full cursor-pointer shadow-md transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </label>
                    </div>

                    <h2 class="text-lg font-bold text-slate-900">{{ auth()->user()->name }}</h2>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">Room {{ auth()->user()->room->room_number ?? '-' }} • Resident</p>

                    <div class="w-full border-t border-slate-100 my-4"></div>

                    {{-- Detail Kontak Singkat --}}
                    <div class="w-full space-y-3.5 text-left text-sm">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email</p>
                                <p class="font-medium text-slate-700 break-all">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Phone</p>
                                <p class="font-medium text-slate-700">{{ auth()->user()->phone ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200 mt-0.5">
                                    AKTIF
                                </span>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="document.getElementById('avatar-input').click()" class="w-full mt-5 border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-sm py-2 rounded-xl transition">
                        Ubah Foto
                    </button>
                </div>

                {{-- Card 2: Informasi Kamar --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Kamar</h3>
                        <svg class="w-5 h-5 text-[#801824]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>

                    <div class="grid grid-cols-2 gap-y-4 gap-x-2 text-sm">
                        <div>
                            <p class="text-[11px] text-slate-400 font-medium">Nomor Kamar</p>
                            <p class="font-bold text-slate-800 text-base">{{ auth()->user()->room->room_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-slate-400 font-medium">Tipe Kamar</p>
                            <p class="font-bold text-slate-800">{{ auth()->user()->room->type ?? 'Standard' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-slate-400 font-medium">Tanggal Masuk</p>
                            <p class="font-bold text-slate-800">{{ auth()->user()->check_in_date ? auth()->user()->check_in_date->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-slate-400 font-medium">Status Sewa</p>
                            <p class="font-bold text-slate-800">{{ auth()->user()->rent_status ?? 'Bulanan' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Form Edit Profil --}}
            <div class="lg:col-span-2">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Hidden File Input --}}
                        <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*">

                        <div>
                            <h3 class="text-base font-bold text-slate-900">Edit Profil</h3>
                            <p class="text-xs text-slate-500">Pastikan data Anda selalu mutakhir untuk kenyamanan komunikasi.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700">Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700">Pekerjaan</label>
                                <input type="text" name="occupation" value="{{ old('occupation', auth()->user()->occupation) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            </div>
                        </div>

                        <div class="border-t border-slate-100 my-6"></div>

                        {{-- Section Password --}}
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ubah Kata Sandi</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5 relative">
                                    <label class="text-xs font-bold text-slate-700">Kata Sandi Baru</label>
                                    <input type="password" name="password" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                                </div>
                                <div class="space-y-1.5 relative">
                                    <label class="text-xs font-bold text-slate-700">Konfirmasi Kata Sandi</label>
                                    <input type="password" name="password_confirmation" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-400">ⓘ Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.</p>
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

        {{-- Grid Info Bawah --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
            {{-- Bantuan --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                <div class="p-2.5 bg-rose-50 text-[#801824] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Butuh Bantuan?</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Hubungi admin jika Anda mengalami kesulitan dalam mengupdate data profil.</p>
                </div>
            </div>

            {{-- Keamanan --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                <div class="p-2.5 bg-rose-50 text-[#801824] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Keamanan Data</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Data Anda dilindungi dengan enkripsi tingkat lanjut sesuai standar privasi.</p>
                </div>
            </div>

            {{-- Aktivitas Login --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                <div class="p-2.5 bg-rose-50 text-[#801824] rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Aktivitas Login</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Terakhir login: Hari ini, 14:20 WIB dari perangkat Chrome (Windows).</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
