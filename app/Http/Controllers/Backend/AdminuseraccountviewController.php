<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminuseraccountviewController extends Controller
{
    public function impersonateUser($userId)
{
    $user = User::findOrFail($userId);

    if (auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }

    // আসল admin কে store করো
    session(['impersonate_admin_id' => auth()->id()]);

    // Impersonate চলছে কিনা সেটা জানানোর জন্য শুধু এইটা দরকার
    session(['impersonating' => true]);

    // User হিসেবে login করো
    auth()->login($user);

    return redirect()->route('frontend.dashboard')
                     ->with('success', 'You are now logged in as ' . $user->name);
}

public function stopImpersonate()
{
    if (!session()->has('impersonate_admin_id')) {
        abort(403, 'Admin session not found.');
    }

    $adminId = session('impersonate_admin_id');

    auth()->logout(); // Current user logout

    // Session clear
    session()->forget(['impersonate_admin_id', 'impersonating']);

    // Admin হিসেবে login
    $admin = User::findOrFail($adminId);
    auth()->login($admin);

    return redirect()->route('admin.dashboard')
                     ->with('success', 'You are now back as Admin.');
}



}
