<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===== USER (PELANGGAN) =====

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Cegah admin login lewat halaman user
        if ($user && $user->role === 'admin') {
            return back()->withErrors([
                'email' => 'Akun ini adalah akun admin. Silakan login di halaman admin.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'role'     => 'user',
            'password' => Hash::make($validated['password']),
        ]);

        // Langsung login setelah daftar, redirect ke dashboard
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!');
    }

    // ===== ADMIN (KARYAWAN) =====

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Cegah user biasa login lewat halaman admin
        if ($user && $user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'Akun ini bukan akun admin.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    // ===== LOGOUT (SHARED) =====

    public function logout(Request $request)
    {
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($isAdmin ? 'admin.login' : 'home')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}