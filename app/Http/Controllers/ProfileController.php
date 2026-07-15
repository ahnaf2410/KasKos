<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil tenant.
     */
    public function edit(Request $request): View
    {
        // Diarahkan ke folder view tempat kamu menyimpan blade tadi
        return view('tenant.profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update data profil, foto, dan kata sandi.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Isi data teks yang sudah lolos validasi (name, email, phone, occupation)
        $user->fill($request->safe()->only(['name', 'email', 'phone', 'occupation']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 2. Proses upload foto profil (Avatar) jika ada file baru
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama dari storage jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Simpan yang baru ke folder 'avatars'
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // 3. Proses ganti password jika kolom password diisi oleh tenant
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Redirect kembali ke halaman edit profil dengan status sukses
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
