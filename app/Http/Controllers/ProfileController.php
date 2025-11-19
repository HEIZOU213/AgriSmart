<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; // <-- Penting
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Isi data text biasa
        $user->fill($request->validated());

        // Jika email berubah, reset verifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // [KODE BARU] Logika Upload Foto Profil
        if ($request->hasFile('foto_profil')) {
            // 1. Validasi manual sederhana (atau bisa di Request)
            $request->validate([
                'foto_profil' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // 2. Hapus foto lama jika ada
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // 3. Simpan foto baru
            $path = $request->file('foto_profil')->store('profil', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

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

        // [KODE BARU] Hapus foto profil saat akun dihapus
        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}