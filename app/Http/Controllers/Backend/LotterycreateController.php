<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use Illuminate\Http\Request;

class LotterycreateController extends Controller
{
    /**
     * Display a listing of the lotteries.
     */
    public function index()
    {
        $lotteries = Lottery::orderBy('created_at', 'desc')->get();
        return view('admin.Lottery.index', compact('lotteries'));
    }

    /**
     * Show the form for creating a new lottery.
     */
    public function create()
    {
        return view('admin.Lottery.create');
    }

    /**
     * Store a newly created lottery in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'draw_date'   => 'required|date',
            'win_type'    => 'required|string',
            'first_prize' => 'nullable|string',
            'second_prize'=> 'nullable|string',
            'third_prize' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $lottery = new Lottery();
        $lottery->name        = $request->name;
        $lottery->price       = $request->price;
        $lottery->description = $request->description;
        $lottery->draw_date   = $request->draw_date;
        $lottery->win_type    = $request->win_type;
        $lottery->first_prize = $request->first_prize;
        $lottery->second_prize= $request->second_prize;
        $lottery->third_prize = $request->third_prize;
        $lottery->status      = $request->status;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/Lottery'), $filename);
            $lottery->photo = $filename;
        }

        $lottery->save();

        return redirect()->route('lottery.index')->with('success', 'Lottery created successfully!');
    }

    /**
     * Show the form for editing the specified lottery.
     */
    public function edit($id)
    {
        $lottery = Lottery::findOrFail($id);
        return view('admin.Lottery.edit', compact('lottery'));
    }

    /**
     * Update the specified lottery in storage.
     */
    public function update(Request $request, $id)
    {
        $lottery = Lottery::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'new_photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'draw_date'   => 'required|date',
            'win_type'    => 'required|string',
            'first_prize' => 'nullable|string',
            'second_prize'=> 'nullable|string',
            'third_prize' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $lottery->name        = $request->name;
        $lottery->price       = $request->price;
        $lottery->description = $request->description;
        $lottery->draw_date   = $request->draw_date;
        $lottery->win_type    = $request->win_type;
        $lottery->first_prize = $request->first_prize;
        $lottery->second_prize= $request->second_prize;
        $lottery->third_prize = $request->third_prize;
        $lottery->status      = $request->status;

        if ($request->hasFile('new_photo')) {
            // পুরানো ফটো ডিলিট
            if ($lottery->photo && file_exists(public_path('uploads/Lottery/'.$lottery->photo))) {
                unlink(public_path('uploads/Lottery/'.$lottery->photo));
            }
            $file = $request->file('new_photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/Lottery'), $filename);
            $lottery->photo = $filename;
        }

        $lottery->save();

        return redirect()->route('lottery.index')->with('success', 'Lottery updated successfully!');
    }

    /**
     * Remove the specified lottery from storage.
     */
    public function destroy($id)
    {
        $lottery = Lottery::findOrFail($id);

        if ($lottery->photo && file_exists(public_path('uploads/Lottery/'.$lottery->photo))) {
            unlink(public_path('uploads/Lottery/'.$lottery->photo));
        }

        $lottery->delete();

        return redirect()->route('lottery.index')->with('success', 'Lottery deleted successfully!');
    }
}
