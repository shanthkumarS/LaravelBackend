<?php

namespace App\Http\Middleware\Authentication;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ApiMiddleware
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
        $authorization = base64_decode(trim($request->header('Authorization'), 'Basic '));
        $credentials = explode(':', $authorization);

        $user = Cache::get($credentials[0]);

        if (!$user) {
            throw new Exception("Session expired", 402);
        }

        if (!Hash::check($credentials[1], $user->password)) {
            throw new Exception("Invalid Credentials", 403);
        }

        $this->bindUser($user);

        return $next($request);
    }

    private function bindUser(User $user)
    {
        App::singleton('user', function($app) use ($user) {
            return $user;
        });
    }
}
