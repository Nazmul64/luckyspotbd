<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User_widthdraw;
use App\Models\WithdrawCommission;
use Illuminate\Http\Request;

class AdminWithdrawController extends Controller
{
    public function Withdrawshow()
{
    // withdraw এর সাথে user relation নিয়ে আসবো
    $withdrawals = User_widthdraw::with('user')->orderBy('created_at', 'desc')->get();
    return view('admin.widthraw.index', compact('withdrawals'));
}
  public function approve($id)
    {
        $withdraw = User_widthdraw::findOrFail($id);
        $user = $withdraw->user;

        $withdraw_commission = WithdrawCommission::first();
        $commission_percentage = $withdraw_commission->withdraw_commission ?? 0;

        $charge = ($commission_percentage / 100) * $withdraw->amount;
        $total_deduction = $withdraw->amount + $charge;

        if ($user->balance < $total_deduction) {
            return back()->with('error', 'User balance insufficient.');
        }

        $user->balance -= $total_deduction;
        $user->save();

        $withdraw->charge = $charge;
        $withdraw->status = 'approved';
        $withdraw->save();

        return back()->with('success', 'Withdrawal approved successfully.');
    }

    // Reject withdrawal
    public function reject($id)
    {
        $withdraw = User_widthdraw::findOrFail($id);
        $withdraw->status = 'rejected';
        $withdraw->save();

        return back()->with('success', 'Withdrawal rejected successfully.');
    }
}
