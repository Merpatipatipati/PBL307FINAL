<?php

namespace App\Http\Controllers\inside;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // Perlu diimport untuk menggunakan Auth
use App\Models\Product; // Perlu diimport untuk menggunakan model Product

class HomeController extends Controller
{
    // Constructor untuk menerapkan middleware auth
    public function __construct()
    {
        $this->middleware('auth'); // Ini memastikan hanya user yang sudah login bisa akses halaman ini
    }

    // Fungsi untuk menampilkan halaman home
    public function index()
    {
   // Mengambil semua produk yang belum di-takedown
   $products = Product::whereHas('user', function ($query) {
    $query->where('status', '!=', 'banned');
})->get();
   // Mengirim data produk ke view 'home'
   return view('inside.home', compact('products'));
    }
}
