<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status === 'Banned') {
            Auth::logout(); // Logout user
            return redirect('/login')->withErrors(['message' => 'Your account has been banned.']);
        }

        return $next($request);
    }
}


