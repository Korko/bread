<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Carbon\Carbon;
use Closure;

class CheckUserExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = User::find(Auth::id());
        if ($user->expiration === null || Carbon::parse($user->expiration)->gt(Carbon::now())) {
            return $next($request);
        }

        return abort(403, 'Access expired');
    }
}
