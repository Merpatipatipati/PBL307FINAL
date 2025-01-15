<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckVPNIP
{
public function handle(Request $request, Closure $next)
    {
        // Rentang IP yang diizinkan (192.168.10.0/24)
        $allowedRange = '192.168.10.0/24';

        // Ambil IP dari header X-Forwarded-For jika ada, atau gunakan IP asli
        $clientIP = $request->header('X-Forwarded-For')
            ? explode(',', $request->header('X-Forwarded-For'))[0]  // Ambil IP pertama
            : $request->ip();

        Log::info('Client IP: ' . $clientIP); // Debugging untuk memverifikasi IP

        // Validasi IP terhadap rentang yang diizinkan
        if (!$this->isIPInRange($clientIP, $allowedRange)) {
            abort(403, 'Access denied. Hayolo, your IP is not allowed.');
        }

        return $next($request);
    }

    // Fungsi untuk mengecek apakah IP ada dalam rentang
    private function isIPInRange($ip, $range)
    {
        // Pisahkan subnet dan bitmask
        [$subnet, $bits] = explode('/', $range);
        $ip = ip2long($ip);           // Ubah IP menjadi long
        $subnet = ip2long($subnet);   // Ubah subnet menjadi long
        $mask = -1 << (32 - $bits);  // Hitung subnet mask
        $subnet &= $mask;             // Terapkan subnet mask ke subnet

        return ($ip & $mask) === $subnet; // Cek apakah IP ada dalam rentang
    }
}
