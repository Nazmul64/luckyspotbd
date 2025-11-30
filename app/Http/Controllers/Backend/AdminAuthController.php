<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Auth facade import করতে হবে
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function admin_login()
    {
        return view('admin.auth.login');
    }

    public function admin_login_submit(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate using default web guard
        if (Auth::attempt($credentials)) {
            // Check if the logged-in user is admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ])->withInput();
            }
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }


    public function admin_logout(Request $request)
{
    auth()->logout(); // User logout
    $request->session()->invalidate(); // Session invalidate
    $request->session()->regenerateToken(); // CSRF token regenerate
    return redirect()->route('admin.login'); // Redirect to login page
}

}
