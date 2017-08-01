<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth as AuthenticateWithBasicAuthParent;

class AuthenticateWithBasicAuth extends AuthenticateWithBasicAuthParent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        return $this->auth->guard($guard)->basic('name') ?: $next($request);
    }
}
