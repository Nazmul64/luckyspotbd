<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDepositeApprovedController extends Controller
{
     // Admin: list all deposits
    public function approveindex() {
        $deposite = Deposite::with('user')->latest()->get();
        return view('admin.userdeposite.index', compact('deposite'));
    }

    // Admin: update deposit status
    public function updateStatus(Request $request, Deposite $deposit) {
        $request->validate(['status'=>'required|in:pending,approved,rejected']);
        $deposit->update(['status'=>$request->status]);
        return back()->with('success', 'Deposit status updated successfully!');
    }

    // Admin: delete deposit
    public function approvedelete($id) {
        $deposit =Deposite::findOrFail($id);
        $deposit->delete();
        return back()->with('success','Deposit deleted successfully!');
    }


public function depositesedit($id) {
    $deposit = Deposite::findOrFail($id);
    return view('admin.userdeposite.userdepositeedit', compact('deposit'));
}
}
