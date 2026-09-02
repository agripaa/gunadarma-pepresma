<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (int) Auth::user()->role === 1) {
            return $next($request);
        }

        abort(403);
    }
}
