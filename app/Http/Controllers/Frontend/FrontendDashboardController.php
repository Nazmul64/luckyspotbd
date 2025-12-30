<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use App\Models\Lottery;
use App\Models\User;
use App\Models\Userpackagebuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendDashboardController extends Controller
{
public function frontend()
{
    $userId = Auth::id();

    // Active lottery packages (সবাই দেখতে পারবে)
    $package_show = Lottery::where('status', 'active')
        ->orderBy('draw_date', 'asc')
        ->get();

    // Total packages bought by logged-in user
    $total_buyer = Userpackagebuy::where('user_id', $userId)->count();

    // Total balance for logged-in user only
    $total_balance = User::where('id', $userId)->sum('balance');

    // Total approved deposit for logged-in user only
    $total_deposite = Deposite::where('user_id', $userId)
        ->where('status', 'approved')
        ->sum('amount');

    // Deposit history for authenticated user
    $deposite_history = Deposite::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('frontend.dashboard.index', compact(
        'total_deposite',
        'total_balance',
        'deposite_history',
        'package_show',
        'total_buyer'
    ));
}

}
