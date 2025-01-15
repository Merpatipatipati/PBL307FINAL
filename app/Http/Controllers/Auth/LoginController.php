<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan formulir login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan untuk mengganti dengan view yang sesuai
    }

    /**
     * Memproses login.
     */
public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'login' => 'required|string', // Login bisa berupa email atau username
        'password' => 'required|string',
    ]);

    // Tentukan login type, apakah email atau username
    $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    // Upaya login
    if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
        // Ambil data user yang berhasil login
        $user = Auth::user();

        // Cek apakah user sudah terverifikasi
        if ($user->status === 'non-verified') {
            Auth::logout(); // Logout jika tidak terverifikasi
            return redirect()->route('login')->with('error', 'Your account is not verified. Please verify your account before logging in.');
        }

        // Cek apakah status user adalah 'banned'
        if ($user->status === 'banned') {
            Auth::logout(); // Logout jika dibanned
            return redirect()->route('login')->with('error', 'Your account has been banned.');
        }

        // Jika login berhasil dan akun valid, redirect ke halaman yang dituju
        return redirect()->intended('home')->with('success', 'Login berhasil!');
    }

    // Jika login gagal, kembali ke formulir login dengan pesan kesalahan
    return back()->withErrors([
        'login' => 'Username, email, atau password salah.',
    ])->withInput($request->only('login'));
}

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
