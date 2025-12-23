<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserprofileController extends Controller
{
    // SHOW PROFILE PAGE
    public function profile()
    {
        return view('frontend.profile.index');
    }

    // UPDATE PROFILE
    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // VALIDATION
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'country' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'number' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // UPDATE FIELDS
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username;
        $user->country    = $request->country;
        $user->address    = $request->address;
        $user->zip_code   = $request->zip_code;
        $user->number     = $request->number;

        // IMAGE UPLOAD
        if ($request->hasFile('profile_photo')) {

            // DELETE OLD IMAGE
            $oldPath = public_path('uploads/profile/' . $user->profile_photo);
            if ($user->profile_photo && file_exists($oldPath)) {
                unlink($oldPath);
            }

            // UPLOAD NEW
            $file = $request->file('profile_photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);

            $user->profile_photo = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
