<?php

namespace App\Http\Middleware;

use Closure;

class Middleware extends Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        return $next($request)
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000')
        ->header('Access-Control-Allow-Methods', '*')
        ->header('Access-Control-Allow-Credentials', true)
        ->header('Access-Control-Allow-Headers', '*')
        ->header('Accept', 'application/json');
    }

}
