<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class SetupOnly
{
    // ponytail: /registerSuperAdmin creates a role=1 account with no auth, so it
    // is only reachable while no super admin exists. Delete the routes entirely
    // if bootstrapping ever moves to a seeder.
    public function handle($request, Closure $next)
    {
        if (User::where('role', 1)->exists()) {
            abort(404);
        }

        return $next($request);
    }
}
