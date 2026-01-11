<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
        /**
     * Mengarahkan pengguna ke halaman otentikasi Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menangani callback dari Google setelah otentikasi.
     */
public function handleGoogleCallback()
    {
        try {
            // 1. Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // 2. Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                // Jika user sudah ada, update google_id jika belum ada & AUTO VERIFIKASI
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(), // <--- TAMBAHKAN INI (PENTING)
                ]);
            } else {
                // Jika user belum ada, buat baru & LANGSUNG VERIFIKASI
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(16)), // Password acak
                    'role' => 'customer',
                    'email_verified_at' => now(), // <--- TAMBAHKAN INI (PENTING)
                ]);
            }

            // 3. Login user tersebut
            Auth::login($user);

            // 4. Redirect ke Dashboard/Home
            return redirect()->route('home')->with('success', 'Berhasil login dengan Google!');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
        }
    }
}
