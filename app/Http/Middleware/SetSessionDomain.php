<?php



namespace App\Http\Middleware;



use Closure;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;



class SetSessionDomain

{

    public function handle(Request $request, Closure $next)

    {

        // Menentukan domain atau IP untuk session domain

        $host = $request->getHost();

        

        // Menyesuaikan session domain berdasarkan host

        if ($host == 'openshop.com' || $host == '10.10.10.3' || $host == '10.10.10.4') {

            Config::set('session.domain', '.openshop.com');  // Sesuaikan dengan domain atau IP yang diinginkan

        } else {

            Config::set('session.domain', null);  // Gunakan default session jika tidak cocok

        }



        return $next($request);

    }

}


