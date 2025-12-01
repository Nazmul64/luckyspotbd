<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CommissionSetting;
use Illuminate\Http\Request;

class CommissionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all commission settings
        $commissions = CommissionSetting::all();
        return view('admin.commissionsetting.index', compact('commissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.commissionsetting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'refer_commission'   => 'required|numeric|min:0',
            'generation_level_1' => 'required|numeric|min:0',
            'generation_level_2' => 'required|numeric|min:0',
            'generation_level_3' => 'required|numeric|min:0',
            'generation_level_4' => 'required|numeric|min:0',
            'generation_level_5' => 'required|numeric|min:0',
            'status'             => 'required|boolean',
        ]);

        CommissionSetting::create($request->all());

        return redirect()->route('commissionsetting.index')
                         ->with('success', 'Commission created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $commission = CommissionSetting::findOrFail($id);
        return view('admin.commissionsetting.edit', compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'refer_commission'   => 'required|numeric|min:0',
            'generation_level_1' => 'required|numeric|min:0',
            'generation_level_2' => 'required|numeric|min:0',
            'generation_level_3' => 'required|numeric|min:0',
            'generation_level_4' => 'required|numeric|min:0',
            'generation_level_5' => 'required|numeric|min:0',
            'status'             => 'required|boolean',
        ]);

        $commission = CommissionSetting::findOrFail($id);
        $commission->update($request->all());

        return redirect()->route('commissionsetting.index')
                         ->with('success', 'Commission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $commission = CommissionSetting::findOrFail($id);
        $commission->delete();

        return redirect()->route('commissionsetting.index')
                         ->with('success', 'Commission deleted successfully.');
    }
}
