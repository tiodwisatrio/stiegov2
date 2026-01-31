<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Allow both admin and developer roles
        if (! $user || ! $user->hasAdminAccess()) {
            abort(403, 'Unauthorized. Admin access only.');
        }

        return $next($request);
    }
}