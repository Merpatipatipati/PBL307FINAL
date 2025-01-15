<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'https://10.10.10.2/admin/*',
        'http://10.10.10.3/admin/*',
        'http://10.10.10.4/admin/*',
    ];
}
