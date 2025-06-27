<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is not authenticated
        if (!Auth::check()) {
            // Save the intended URL in the session for redirecting after login
            Session::put('intended_url', $request->url());

            // Redirect to login with a message
            return redirect()->route('login')->with('warning', 'You have to sign in first.');
        }

        return $next($request);
    }
}
