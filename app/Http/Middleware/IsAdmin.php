<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in AND if their role is 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // User is an admin, allow access
        }

        // User is not an admin (or not logged in), return 403 Forbidden response
        return abort(403, 'Unauthorized Access.');
    }
}