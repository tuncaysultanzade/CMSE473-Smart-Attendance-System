<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response|mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user role is in the allowed roles
        if (in_array($user->user_role, $roles)) {
            return $next($request);
        }

        // Redirect if the user is not authorized
        return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page.');
    }
}
