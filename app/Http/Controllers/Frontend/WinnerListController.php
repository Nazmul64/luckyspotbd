<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\LotteryResult;
use App\Models\User;
use App\Models\Userpackagebuy;
use Illuminate\Http\Request;

class WinnerListController extends Controller
{
    public function winnerlist ()
    {


     // Current logged-in user (for balance)
    $user = auth()->user();
    $userBalance = $user->userdeposite->sum('amount'); // শুধু মোট ব্যালেন্স

    $today   = now()->startOfDay();
    $packages = Lottery::all();

    // All users withdrawals
    $users_widthraw = User::with('userWidthdraws')->get();

    // All users deposits (for recent deposits scroll)
$users_deposite = User::with('userdeposite')->get();

// প্রতিটি user এর total_deposite_balance calculate
$users_deposite->each(function($user) {
    $user->total_deposite_balance = $user->userdeposite->sum('amount')
        +Userpackagebuy::where('user_id', $user->id)->sum('price'); // adjust column
});

// শুধুমাত্র যারা deposits করেছে তারা filter
$users_deposite = $users_deposite->filter(function($user) {
    return $user->total_deposite_balance > 0;
});
    // Package winners
    $packageWinners = [];
    foreach ($packages as $package) {
        $packageWinners[$package->id] =LotteryResult::with(['user', 'userPackageBuy'])
            ->whereHas('userPackageBuy', function ($q) use ($package) {
                $q->where('package_id', $package->id);
            })
            ->where('draw_date', '>=', $today)
            ->orderBy('position')
            ->take(3)
            ->get();
    }

    return view('frontend.dashboard.winnerlist.index', compact(
        'packages',
        'packageWinners',
        'users_widthraw',
        'users_deposite',
        'userBalance',

    ));


    }
}
