<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah admin sudah login
        if (Auth::guard('admin')->check()) {
            // Jika sudah login, arahkan ke dashboard
            return redirect()->route('admin.dashboard')->with('info', 'Anda sudah login sebagai admin.');
        }

        // Jika belum login, lanjutkan permintaan
        return $next($request);
    }
}
