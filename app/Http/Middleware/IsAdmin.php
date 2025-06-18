<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Check if the user is authenticated and has a user_type of "Admin"
        if (Auth::check()) {
            if (Auth::user()->user_types_id === 1) {
                return $next($request);
            }
        }

        // Redirect back with an error message if the user is not an admin
        return redirect()->back()->with('error', 'You cannot access this page!');
    }
}
