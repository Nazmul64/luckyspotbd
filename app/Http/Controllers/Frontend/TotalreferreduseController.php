<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profit;
use Illuminate\Http\Request;

class TotalreferreduseController extends Controller
{
    public function myReferrals()
{
    $commissions = Profit::with('fromUser')
        ->where('user_id', auth()->id()) // যিনি কমিশন পাচ্ছেন
        ->where('amount', '>', 0)        // শুধু income দেখাবে, expense বাদ
        ->latest()
        ->get();

    return view('frontend.dashboard.commissions.commissions', compact('commissions'));
}
}
