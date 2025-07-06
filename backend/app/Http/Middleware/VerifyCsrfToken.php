<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs que deben ser excluidas del middleware CSRF.
     */
    protected $except = [
        'students',
        'students/*',
        'users',
        'users/*',
        'pays',
        'pays/*',
    ];
}
