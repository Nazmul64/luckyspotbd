<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WithdrawCommission;
use Illuminate\Http\Request;

class WithdrawcommissonController extends Controller
{
    public function index()
    {
        $withdrawCommissions = WithdrawCommission::all();
        return view('admin.withdrawcommisson.index', compact('withdrawCommissions'));
    }

    public function create()
    {
        return view('admin.withdrawcommisson.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'withdraw_commission' => 'required|numeric|min:0',
            'minimum_withdraw' => 'required|numeric|min:0',
            'maximum_withdraw' => 'required|numeric|min:0',
            'minimum_deposite' => 'required|numeric|min:0',
            'maximum_deposite' => 'required|numeric|min:0',
            'status' => 'nullable|boolean',
        ]);

        WithdrawCommission::create([
            'withdraw_commission' => $request->withdraw_commission,
            'minimum_withdraw' => $request->minimum_withdraw,
            'maximum_withdraw' => $request->maximum_withdraw,
            'minimum_deposite' => $request->minimum_deposite,
            'maximum_deposite' => $request->maximum_deposite,
            'status' => $request->status ? 1 : 0,
        ]);

        return redirect()->route('withdrawcommisson.index')->with('success', 'Withdraw Commission created successfully.');
    }

    public function edit($id)
    {
        $withdrawCommission = WithdrawCommission::findOrFail($id);
        return view('admin.withdrawcommisson.edit', compact('withdrawCommission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'withdraw_commission' => 'required|numeric|min:0',
            'minimum_withdraw' => 'required|numeric|min:0',
            'maximum_withdraw' => 'required|numeric|min:0',
            'minimum_deposite' => 'required|numeric|min:0',
            'maximum_deposite' => 'required|numeric|min:0',
            'status' => 'nullable|boolean',
        ]);

        $withdrawCommission = WithdrawCommission::findOrFail($id);
        $withdrawCommission->update([
            'withdraw_commission' => $request->withdraw_commission,
            'minimum_withdraw' => $request->minimum_withdraw,
            'maximum_withdraw' => $request->maximum_withdraw,
            'minimum_deposite' => $request->minimum_deposite,
            'maximum_deposite' => $request->maximum_deposite,
            'status' => $request->status ? 1 : 0,
        ]);

        return redirect()->route('withdrawcommisson.index')->with('success', 'Withdraw Commission updated successfully.');
    }

    public function destroy($id)
    {
        $withdrawCommission = WithdrawCommission::findOrFail($id);
        $withdrawCommission->delete();

        return redirect()->route('withdrawcommisson.index')->with('success', 'Withdraw Commission deleted successfully.');
    }
}
