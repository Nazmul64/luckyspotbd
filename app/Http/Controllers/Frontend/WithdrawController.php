<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User_widthdraw;
use App\Models\Waleta_setup;
use App\Models\WithdrawCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    /**
     * Withdraw page
     */
  public function withdraw()
{
    // Active withdraw commission settings
    $withdrawLimit = WithdrawCommission::where('status', 1)->latest()->first();

    // All payment methods
    $payment_method_name = Waleta_setup::all();

    return view('frontend.Withdraw.index', compact(
        'withdrawLimit',
        'payment_method_name'
    ));
}


    /**
     * Submit withdraw request
     */
    public function submit(Request $request)
    {
        $commission = WithdrawCommission::where('status', 1)->latest()->first();

        if (!$commission) {
            return back()->withErrors([
                'amount' => 'Withdraw configuration not available.'
            ]);
        }

        $request->validate([
            'amount' => "required|numeric|min:{$commission->minimum_withdraw}|max:{$commission->maximum_withdraw}",
            'payment_method' => 'required|exists:waleta_setups,id',
            'account_number' => 'required|string|max:191',
        ]);

        $user = Auth::user();

        if ($request->amount > $user->balance) {
            return back()->withErrors([
                'amount' => 'Insufficient balance.'
            ]);
        }

        DB::transaction(function () use ($request, $user) {

            $wallet = Waleta_setup::findOrFail($request->payment_method);

            // ✅ ENSURE STRING VALUE
            $walletName = is_array($wallet->bankname)
                ? implode(', ', $wallet->bankname)
                : (string) $wallet->bankname;

            User_widthdraw::create([
                'user_id'        => $user->id,
                'wallet_name'    => $walletName,
                'account_number' => $request->account_number,
                'amount'         => $request->amount,
                'charge'         => 0,
                'status'         => 'pending',
            ]);

            // 🔒 Optional: lock balance immediately
            $user->decrement('balance', $request->amount);
        });

        return back()->with('success', 'Withdrawal request submitted successfully.');
    }
}
