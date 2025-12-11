<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User_widthdraw;
use App\Models\Waleta_setup;
use App\Models\WithdrawCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    /**
     * Show Withdraw page
     */
    public function Withdraw()
    {
        $Withdraw_limit = WithdrawCommission::latest()->first(); // Get latest withdraw limits
        $payment_methods = Waleta_setup::all(); // Get all payment methods

        return view('frontend.Withdraw.index', compact('Withdraw_limit', 'payment_methods'));
    }

    /**
     * Submit withdraw request
     */
    public function submit(Request $request)
    {
        $commission = WithdrawCommission::where('status', 1)->latest()->first();

        if (!$commission) {
            return back()->withErrors(['amount' => 'Withdraw settings not found. Contact admin.']);
        }

        $minWithdraw = $commission->minimum_withdraw;
        $maxWithdraw = $commission->maximum_withdraw;

        $request->validate([
            'amount' => "required|numeric|min:$minWithdraw|max:$maxWithdraw",
            'account_number' => 'required|string',
            'payment_method' => 'required|exists:waleta_setups,id',
        ], [
            'amount.min' => "Minimum withdraw amount is $minWithdraw.",
            'amount.max' => "Maximum withdraw amount is $maxWithdraw.",
        ]);

        $user = Auth::user();

        if ($request->amount > $user->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance for this withdrawal.']);
        }

        // Fetch selected wallet name
        $wallet = Waleta_setup::find($request->payment_method);

        User_widthdraw::create([
            'user_id' => $user->id,
            'wallet_name' => $wallet->bankname ?? 'N/A',
            'account_number' => $request->account_number,
            'amount' => $request->amount,
            'charge' => 0, // Admin will calculate charge
            'status' => 'pending',
        ]);

        return back()->with('success', 'Withdrawal request submitted successfully. Waiting for admin approval.');
    }

}
