<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;

class CheckPath
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->route()->parameter('path') ?: '';

        if (strpos($path, './') !== false) {
            abort(403, 'Access denied');
        }

        if (!file_exists(public_path('storage/'.$path))) {
            abort(404, 'File not found');
        }

        $user = User::find(Auth::id());
        if (!$user->canAccess($path)) {
            abort(404, 'File not found');
        }

        return $next($request);
    }
}
