<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    /* ======================
        LOGIN
    ====================== */
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /* ======================
        REGISTER
    ====================== */
    public function showRegisterForm()
    {
        return view('register');
    }

public function register(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role
        ]);

        // 3. TRIGGER EVENT UNTUK KIRIM EMAIL (INI KUNCINYA)
        event(new Registered($user));

        // 4. AUTO LOGIN (Agar bisa akses halaman verifikasi yang dilindungi auth)
        Auth::login($user);

        // 5. REDIRECT KE HALAMAN MINTA VERIFIKASI
        return redirect()->route('verification.notice');
    }

    /* ======================
        LOGOUT
    ====================== */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}