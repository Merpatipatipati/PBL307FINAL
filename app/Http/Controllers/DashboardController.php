<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the About page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('dashboard.about'); // Pastikan Anda sudah membuat file view dashboard/about.blade.php
    }

    /**
     * Display the FAQ page.
     *
     * @return \Illuminate\View\View
     */
    public function faq()
    {
        return view('dashboard.faq'); // Pastikan Anda sudah membuat file view dashboard/faq.blade.php
    }

    /**
     * Display the Login page.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('dashboard.login'); // Pastikan Anda sudah membuat file view dashboard/login.blade.php
    }

    public function news()
    {
        return view('dashboard.news'); // Pastikan Anda sudah membuat file view dashboard/faq.blade.php
    }

    public function help()
    {
        return view('dashboard.help'); // Pastikan Anda sudah membuat file view dashboard/faq.blade.php
    }
}

