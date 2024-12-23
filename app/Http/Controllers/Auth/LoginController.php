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
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    // Coba login
    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        // Cek apakah status user adalah 'Banned'
        $user = Auth::user();
        
        if ($user->status === 'banned') {
            // Logout user yang dibanned
            Auth::logout();
            
            // Set pesan banned di session
            return redirect()->route('login')->with('error', 'Your account has been banned.');
        }

        // Jika login berhasil dan akun tidak dibanned, redirect ke halaman yang dituju
        return redirect()->intended('home')->with('success', 'Login berhasil!');
    }

    // Jika login gagal, kembali ke formulir login dengan pesan kesalahan
    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->withInput($request->only('username'));
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
