<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordMail;

class RegisterController extends Controller
{
    // Tampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input pengguna
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan data pengguna ke database
        $user = User::create([
            'fullname' => $validatedData['fullname'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'user',
            'status' => 'non-verified',
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan OTP ke dalam tabel otps
        Otp::create([
            'user_id' => $user->id,
            'otp' => $otp,
        ]);

        // Kirim OTP via email
        Mail::to($user->email)->send(new OtpMail($user, $otp));

        // Redirect ke halaman OTP untuk validasi
        return redirect()->route('otp.form', ['id' => $user->id]);
    }

    // Kirim ulang OTP
    public function sendOtp(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $otp = rand(100000, 999999); // Generate OTP secara acak

        // Simpan OTP baru ke tabel otps
        Otp::create([
    'user_id' => $user->id,
    'otp' => $otp,
    'expires_at' => now()->addMinutes(5), // Tambahkan waktu kadaluarsa
]);

        // Kirim email dengan Mailable
        Mail::to($user->email)->send(new OtpMail($user, $otp));

        return back()->with('success', 'OTP has been sent to your email!');
    }

    // Tampilkan form validasi OTP
    public function showOtpForm($id)
    {
        return view('auth.sendotp', ['id' => $id]);
    }

    // Validasi kode OTP
    public function validateOtp(Request $request, $id)
    {
        // Validasi input pengguna
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Cari OTP di tabel `otps` yang sesuai dengan `user_id`
        $otpRecord = Otp::where('user_id', $user->id)->latest()->first();

        // Periksa apakah OTP ada dan cocok
        if ($otpRecord && $otpRecord->otp == $request->otp) {
            // Hapus OTP dari tabel otps
            $otpRecord->delete();

            // Perbarui status user menjadi verified
            $user->update([
                'status' => 'verified',
            ]);

            return redirect()->route('login')->with('success', 'Your account has been verified! Please log in.');
        }

        return back()->with('error', 'Invalid OTP code.');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Proses permintaan lupa password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate token reset password
        $token = Str::random(64);

        // Simpan token ke tabel password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // Kirim email reset password
        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return back()->with('success', 'A link to reset your password has been sent to your email');
    }

    // Tampilkan form reset password
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cari token di tabel password_resets
        $resetRecord = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$resetRecord || now()->diffInMinutes($resetRecord->created_at) > 60) {
            return back()->with('error', 'Token is invalid or has expired.');
        }

        // Cari user berdasarkan email
        $user = User::where('email', $resetRecord->email)->firstOrFail();

        // Perbarui password user
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus token reset dari tabel password_resets
        DB::table('password_resets')->where('email', $user->email)->delete();

        return redirect()->route('login')->with('success', 'Your password has been successfully updated. Please log in.');
    }
}

