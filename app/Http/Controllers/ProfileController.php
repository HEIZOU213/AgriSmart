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
    // ...
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi file sudah otomatis dijalankan di sini, termasuk validasi text
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Logika Upload Foto Profil
        if ($request->hasFile('foto_profil')) {

            // 2. Hapus foto lama jika ada
            if ($user->foto_profil) {
                // Cek apakah itu path lokal atau URL eksternal (mengandung 'http' atau 'https')
                // Hapus hanya jika itu terlihat seperti path penyimpanan lokal (tidak mengandung skema URL)
                if (!preg_match('#^https?://#i', $user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                }
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