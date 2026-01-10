<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserForgotPasswordController extends Controller
{
    /**
     * Show the forget password form
     */
    public function showForgetForm()
    {
        return view('frontend.auth.forget_password');
    }

    /**
     * Handle sending the reset link
     */
    public function submitForgetForm(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'We could not find a user with that email address.'
        ]);

        try {
            // Find user
            $user = User::where('email', $request->email)->first();

            // Generate token
            $token = Str::random(64);
            $expires = Carbon::now()->addMinutes(30);

            // Update token and expiry in users table
            $user->update([
                'reset_token' => $token,
                'reset_token_expires_at' => $expires
            ]);

            // Log the token generation
            Log::info('Password reset token generated', [
                'email' => $user->email,
                'token' => $token,
                'token_length' => strlen($token),
                'expires_at' => $expires->toDateTimeString()
            ]);

            // Build reset URL
            $resetUrl = route('password.reset', ['token' => $token]);

            Log::info('Reset URL generated', [
                'url' => $resetUrl,
                'url_length' => strlen($resetUrl)
            ]);

            // Send email
            Mail::send('frontend.auth.email.forget_password', [
                'token' => $token,
                'name' => $user->name,
                'email' => $user->email,
                'resetUrl' => $resetUrl
            ], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Password Reset Request');
            });

            Log::info('Password reset email sent successfully', ['email' => $user->email]);

            return back()->with('success', 'We have e-mailed your password reset link! Please check your inbox.');

        } catch (\Exception $e) {
            Log::error('Password reset failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['email' => 'Failed to send reset email. Please try again.']);
        }
    }

    /**
     * Show the reset password form
     */
    public function showResetForm($token)
    {
        // Log incoming request
        Log::info('Reset form accessed', [
            'token' => $token,
            'token_length' => strlen($token),
            'url' => request()->fullUrl()
        ]);

        // Check if token exists and is valid
        $user = User::where('reset_token', $token)
            ->where('reset_token_expires_at', '>', Carbon::now())
            ->first();

        // Log database query result
        Log::info('Database token lookup', [
            'token_searched' => $token,
            'user_found' => $user ? true : false,
            'user_email' => $user ? $user->email : null
        ]);

        // If no user found, check why
        if (!$user) {
            // Check if token exists but expired
            $expiredUser = User::where('reset_token', $token)->first();

            if ($expiredUser) {
                Log::warning('Token found but expired', [
                    'email' => $expiredUser->email,
                    'token' => $token,
                    'expires_at' => $expiredUser->reset_token_expires_at,
                    'current_time' => Carbon::now(),
                    'difference_minutes' => $expiredUser->reset_token_expires_at
                        ? Carbon::now()->diffInMinutes($expiredUser->reset_token_expires_at, false)
                        : 'N/A'
                ]);

                return redirect()->route('user.forget.password')
                    ->withErrors(['email' => 'This password reset link has expired. Please request a new one.']);
            }

            // Token doesn't exist at all
            Log::warning('Token not found in database', [
                'token_received' => $token,
                'all_tokens' => User::whereNotNull('reset_token')->pluck('reset_token', 'email')->toArray()
            ]);

            return redirect()->route('user.forget.password')
                ->withErrors(['email' => 'This password reset link is invalid. Please request a new one.']);
        }

        // Valid token found
        Log::info('Valid token found, showing reset form', [
            'email' => $user->email,
            'token' => $token
        ]);

        return view('frontend.auth.reset_password', [
            'token' => $token,
            'email' => $user->email
        ]);
    }

    /**
     * Handle password reset
     */
    public function submitResetForm(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.exists' => 'This email is not registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'token.required' => 'Reset token is missing.'
        ]);

        // Log the reset attempt
        Log::info('Password reset form submitted', [
            'email' => $request->email,
            'token' => $request->token,
            'token_length' => strlen($request->token)
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::error('User not found', ['email' => $request->email]);
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'User not found!']);
        }

        // Log user details
        Log::info('User found for password reset', [
            'user_id' => $user->id,
            'email' => $user->email,
            'stored_token' => $user->reset_token,
            'received_token' => $request->token,
            'tokens_match' => $user->reset_token === $request->token,
            'stored_token_length' => $user->reset_token ? strlen($user->reset_token) : 0,
            'received_token_length' => strlen($request->token),
            'expires_at' => $user->reset_token_expires_at,
            'now' => Carbon::now(),
            'is_expired' => $user->reset_token_expires_at
                ? $user->reset_token_expires_at < Carbon::now()
                : true
        ]);

        // Check if token is null
        if (!$user->reset_token) {
            Log::warning('No reset token found', ['email' => $request->email]);
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'No password reset request found. Please request a new password reset.']);
        }

        // Check if token has expired
        if (!$user->reset_token_expires_at || $user->reset_token_expires_at < Carbon::now()) {
            Log::warning('Reset token expired', [
                'email' => $request->email,
                'expired_at' => $user->reset_token_expires_at,
                'current_time' => Carbon::now()
            ]);

            // Clear expired token
            $user->update([
                'reset_token' => null,
                'reset_token_expires_at' => null
            ]);

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'This reset link has expired. Please request a new password reset.']);
        }

        // Check if token matches
        if ($user->reset_token !== $request->token) {
            Log::warning('Token mismatch', [
                'email' => $request->email,
                'expected_token' => $user->reset_token,
                'received_token' => $request->token
            ]);

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Invalid reset link. Please request a new password reset.']);
        }

        // All checks passed - update password
        try {
            $user->update([
                'password' => Hash::make($request->password),
                'reset_token' => null,
                'reset_token_expires_at' => null
            ]);

            Log::info('Password reset successful', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return redirect()->route('frontend.login')
                ->with('success', 'Your password has been changed successfully! Please login with your new password.');

        } catch (\Exception $e) {
            Log::error('Failed to update password', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Failed to reset password. Please try again.']);
        }
    }
}
