<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PaswordchangeController extends Controller
{
    public function password(){
        return view('frontend.password.password');
    }
       public function passwordChange(Request $request)
    {

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed', // requires new_password_confirmation field
        ]);

        $user =Auth::user();

        // Check old password
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password does not match our records.');
        }

        // Update password
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
