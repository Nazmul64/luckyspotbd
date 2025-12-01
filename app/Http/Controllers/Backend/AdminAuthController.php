<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function admin_login()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login submission.
     */
    public function admin_login_submit(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt login
        if (Auth::attempt($credentials)) {

            // Check if user is admin
            if (Auth::user()->role === 'admin') {
                // Successful login
                return redirect()->route('admin.dashboard')
                                 ->with('success', 'Admin login successfully!');
            } else {
                // Not an admin, logout and redirect back
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ])->withInput();
            }
        }

        // Login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Admin logout
     */
    public function admin_logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Invalidate session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect()->route('admin.login')
                         ->with('success', 'Admin logged out successfully!');
    }
}
