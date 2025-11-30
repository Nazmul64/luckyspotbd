<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Adminmiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
          // যদি user login না থাকে
        if (!Auth::check()) {
            return redirect()->route('admin.login'); // login page redirect
        }

        // যদি logged-in user admin না হয়
        if (Auth::user()->role !== 'admin') {
            return redirect('/'); // non-admin redirect
        }

        return $next($request);
    }
}
