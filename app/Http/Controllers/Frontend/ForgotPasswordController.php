<?php

namespace App\Http\Controllers\Userauth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
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
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = Str::random(64);
        $expires = Carbon::now()->addMinutes(30); // token valid for 30 minutes

        // Update token and expiry in users table
        $user->update([
            'reset_token' => $token,
            'reset_token_expires_at' => $expires
        ]);

        // Send email with Bootstrap 5 friendly template
        Mail::send('Frontend.email.forget_password', [
            'token' => $token,
            'name' => $user->name
        ], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Password Reset Notification');
        });

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    /**
     * Show the reset password form
     */
    public function showResetForm($token)
    {
        return view('frontend.auth.reset_password', ['token' => $token]);
    }

    /**
     * Handle password reset
     */
    public function submitResetForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ]);

        // Find user by email and valid token
        $user = User::where('email', $request->email)
            ->where('reset_token', $request->token)
            ->where('reset_token_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid or expired token!']);
        }

        // Update password and clear token
        $user->update([
            'password' => Hash::make($request->password),
            'reset_token' => null,
            'reset_token_expires_at' => null
        ]);

        return redirect()->route('user.login')->with('success', 'Your password has been changed successfully!');
    }
}
