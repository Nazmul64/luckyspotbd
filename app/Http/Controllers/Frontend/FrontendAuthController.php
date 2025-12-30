<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontendAuthController extends Controller
{
    /**
     * Show login page
     */
    public function frontend_login()
    {
        return view('frontend.auth.login');
    }

    /**
     * Handle login form submit
     */
    public function frontend_login_submit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            return redirect()->intended(route('frontend.dashboard'))
                ->with('success', 'Login successful! Welcome back ' . $user->name);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
    }

    /**
     * Logout user
     */
    public function frontend_logout()
    {
        Auth::logout();
        return redirect()->route('frontend.login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show registration page
     */
  /**
 * Show registration page
 */
public function frontend_register(Request $request)
{
    // Get ref code from URL parameter
    $refCode = $request->query('ref');

    return view('frontend.auth.register', compact('refCode'));
}

    /**
     * Handle registration form submit
     */
 public function frontend_register_submit(Request $request)
{
    $request->validate([
        'first_name'            => 'required|string|max:255',
        'last_name'             => 'required|string|max:255',
        'email'                 => 'required|email|unique:users,email',
        'username'              => 'required|string|max:255|unique:users,username',
        'number'                => 'required|string|max:20|unique:users,number',
        'country'               => 'required|string|max:255',
        'phone_code'            => 'required|string',
        'ref_code'              => 'nullable|string|exists:users,ref_code', // Changed from number to string
        'password'              => 'required|string|min:6|confirmed',
    ]);

    // Phone number with code
    $fullPhone = $request->phone_code . $request->number;

    // Full name
    $fullName = $request->first_name . ' ' . $request->last_name;

    // Referral
    $referredBy = null;
    if ($request->filled('ref_code')) {
        $refUser = User::where('ref_code', $request->ref_code)->first();
        if ($refUser) {
            $referredBy = $refUser->id;
        }
    }

    // Generate unique referral code
    do {
        $randomRefCode = strtoupper(Str::random(8));
    } while (User::where('ref_code', $randomRefCode)->exists());

    // Create new user
    $user = User::create([
        'first_name'  => $request->first_name,
        'last_name'   => $request->last_name,
        'name'        => $fullName,
        'email'       => $request->email,
        'username'    => $request->username,
        'number'      => $fullPhone,
        'country'     => $request->country,
        'password'    => Hash::make($request->password),
        'ref_code'    => $randomRefCode,
        'referred_by' => $referredBy,
        'status'      => 'active',
        'role'        => 'user',
    ]);

    // Auto login
    Auth::login($user);

    return redirect()->route('frontend.dashboard')
        ->with('success', 'Registration successful! Welcome ' . $fullName);
}
}
