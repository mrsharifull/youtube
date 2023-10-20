<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class userOradminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and has either the "user" or "admin" role.
        if (auth()->user() && (auth()->user()->role == 'user' || auth()->user()->role == 'admin')) {
            return $next($request);
        }

        // If the user doesn't meet the role criteria, you can redirect them or return a 403 Forbidden response.
        return abort(403, 'Unauthorized');
    }
}
