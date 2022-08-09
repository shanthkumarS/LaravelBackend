<?php

namespace App\Http\Middleware\Authentication;

use App\Models\Role;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = App::make('user');
        $role = $user->roles->where('name', 'admin')->first();
        if (! $role instanceof Role) {
            throw new Exception("You are not authorized to access this page");
        }
        return $next($request);
    }
}
