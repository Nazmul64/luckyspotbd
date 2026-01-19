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

    // Active lottery packages with pagination (6 per page = 2 rows × 3 columns)
    // Guest users can also see packages, but only logged-in users can buy
    $package_show = Lottery::where('status', 'active')
        ->orderBy('draw_date', 'asc')
        ->paginate(3); // Changed from take(3)->get() to paginate(6)

    // Initialize variables for logged-in users only
    $total_buyer = 0;
    $total_balance = 0;
    $total_deposite = 0;
    $deposite_history = collect(); // Empty collection for guests

    // Only fetch user-specific data if authenticated
    if ($userId) {
        // Total packages bought by logged-in user
        $total_buyer = Userpackagebuy::where('user_id', $userId)->count();

        // Total balance for logged-in user only
        $total_balance = User::where('id', $userId)->value('balance') ?? 0;

        // Total approved deposit for logged-in user only
        $total_deposite = Deposite::where('user_id', $userId)
            ->where('status', 'approved')
            ->sum('amount');

        // Deposit history with pagination for authenticated user
        $deposite_history = Deposite::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(3); // Added pagination for transaction history
    }

    return view('frontend.dashboard.index', compact(
        'total_deposite',
        'total_balance',
        'deposite_history',
        'package_show',
        'total_buyer'
    ));
}

}
