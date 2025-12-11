<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use App\Models\Waleta_setup;
use App\Models\WithdrawCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositeController extends Controller
{
   public function deposte_index() {
    // সর্বশেষ সেট করা ডিপোজিট সীমা
    $deposite_limit = WithdrawCommission::latest()->first();
    $payment_method_name = Waleta_setup::all();

    return view('frontend.deposite.index', compact('payment_method_name', 'deposite_limit'));
}

  public function store(Request $request)
    {
        // Get latest min/max deposit limits
        $deposite_limit = WithdrawCommission::latest()->first();
        $min = $deposite_limit->minimum_deposite ?? 0;
        $max = $deposite_limit->maximum_deposite ?? 999999999;

        // Validate request
        $request->validate([
            'amount'         => "required|numeric|min:$min|max:$max",
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'screenshot'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'amount.min' => "Minimum deposit is $min টাকা",
            'amount.max' => "Maximum deposit is $max টাকা",
        ]);

        // Handle screenshot upload
        $fileName = null;
        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/deposites'), $fileName);
        }

        // Create deposit record
        Deposite::create([
            'user_id'        => Auth::id(),
            'amount'         => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'screenshot'     => $fileName,
            'status'         => 'pending', // default
        ]);

        return back()->with('success', 'Deposit request submitted successfully!');
    }
}
