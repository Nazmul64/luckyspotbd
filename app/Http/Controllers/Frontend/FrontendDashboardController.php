<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use App\Models\Lottery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendDashboardController extends Controller
{
    public function frontend()
    {
        $package_show=Lottery::all();
        $total_balance=User::sum('balance');
        $total_deposite=Deposite::where('status','approved')->sum('amount');
        $deposite_history = Deposite::where('user_id',Auth::id())->orderBy('created_at', 'desc')->get();
        return view('frontend.dashboard.index',compact('total_deposite','total_balance','deposite_history','package_show'));
    }
}
