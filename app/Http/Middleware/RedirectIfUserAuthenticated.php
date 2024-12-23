<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfUserAuthenticated
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
        // Periksa apakah user sudah login di guard default (user)
        if (Auth::guard('user')->check()) {
            return redirect()->route('home')->with('info', 'Anda sudah login sebagai user.');
        }

        return $next($request);
    }
}

