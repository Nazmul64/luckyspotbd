<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Usermiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // User is not logged in
        if (!Auth::check()) {
            return redirect()->route('frontend.login')
                ->with('error', 'Please login first.');
        }

        // User is logged in but role is not "user"
        if (Auth::user()->role !== 'user') {
            Auth::logout();
            return redirect()->route('frontend.login')
                ->with('error', 'Unauthorized access!');
        }

        return $next($request);
    }
}
