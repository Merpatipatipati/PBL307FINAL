<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Product;

class CheckTakedownProduct
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
        $product = Product::find($request->route('id'));

        // Jika produk ditakedown, tampilkan halaman 404 atau redirect
        if ($product && $product->takedown) {
            return abort(404); // Atau bisa redirect ke halaman lain
        }

        return $next($request);
    }
}
