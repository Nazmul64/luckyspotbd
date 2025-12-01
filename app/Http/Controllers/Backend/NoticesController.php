<?php

namespace App\Http\Controllers\Backend;

use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices=Notice::all();
        return view('admin.notices.index',compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{


    // Store notice in database
    Notice::create([
        'notices_text' => $request->notices_text,
    ]);

    // Redirect with success message
    return redirect()->route('notices.index')
                     ->with('success', 'Notice created successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit($id)
{
    $notice = Notice::findOrFail($id);
    return view('admin.notices.edit', compact('notice'));
}


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{


    // Find the notice
    $notice = Notice::findOrFail($id);

    // Update data
    $notice->update([
        'notices_text' => $request->notices_text,
    ]);

    // Redirect back with success message
    return redirect()->route('notices.index')->with('success', 'Notice updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Find the notice by ID
    $notice = Notice::findOrFail($id);

    $notice->delete();

    // Redirect back with success message
    return redirect()->route('notices.index')
                     ->with('success', 'Notice deleted successfully!');
}
}
