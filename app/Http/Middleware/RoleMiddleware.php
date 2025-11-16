<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            abort(403, 'Not logged in');
        }

        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized. Your role: '.Auth::user()->role.', required: '.$role);
        }

        return $next($request);
    }
}
