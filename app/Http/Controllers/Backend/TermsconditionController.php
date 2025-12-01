<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Termscondition;
use Illuminate\Http\Request;

class TermsconditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $termsconditions = Termscondition::all();
        return view('admin.termscondition.index', compact('termsconditions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.termscondition.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Termscondition::create([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('Termscondition.index')
                         ->with('success', 'Terms & Conditions created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $termscondition = Termscondition::findOrFail($id);
        return view('admin.termscondition.edit', compact('termscondition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $termscondition = Termscondition::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $termscondition->update($request->only(['title', 'description']));

        return redirect()->route('Termscondition.index')
                         ->with('success', 'Terms & Conditions updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $termscondition = Termscondition::findOrFail($id);
        $termscondition->delete();

        return redirect()->route('Termscondition.index')
                         ->with('success', 'Terms & Conditions deleted successfully.');
    }
}
