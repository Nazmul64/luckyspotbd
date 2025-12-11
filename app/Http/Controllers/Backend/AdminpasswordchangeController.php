<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminpasswordchangeController extends Controller
{
    /**
     * Show password change page
     */
    public function adminpasswordchange()
    {
        return view('admin.adminpasswordchange.index');
    }

    /**
     * Submit password update
     */
    public function adminpasswordsubmit(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->with('error', 'Old password does not match our records.');
        }

        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }


    /**
     * Show admin profile page
     */
    public function adminProfile()
    {
        return view('admin.adminpasswordchange.profile');
    }


    /**
     * Update admin profile
     */
    public function adminProfileSubmit(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        // VALIDATION FIXED ✔
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $admin->id,

            // Correct Image Validation
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update basic info
        $admin->name  = $request->name;
        $admin->email = $request->email;

        // Handle profile image upload
        if ($request->hasFile('profile_photo')) {

            $file = $request->file('profile_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/admin'), $filename);

            // Delete old photo if exists
            if ($admin->profile_photo && file_exists(public_path('uploads/admin/' . $admin->profile_photo))) {
                @unlink(public_path('uploads/admin/' . $admin->profile_photo));
            }

            $admin->profile_photo = $filename;
        }

        $admin->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
