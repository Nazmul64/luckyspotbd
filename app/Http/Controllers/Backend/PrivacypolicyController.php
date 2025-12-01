<?php

namespace App\Http\Controllers\Backend;

use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\Privacypolicy;
use Illuminate\Http\Request;

class PrivacypolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $privacypolicies = Privacypolicy::all();
        return view('Admin.privacypolicy.index',compact('privacypolicies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.privacypolicy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Privacypolicy::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('privacypolicy.index')->with('success', 'Privacy Policy created successfully.');
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
    $privacypolicy = Privacypolicy::findOrFail($id);
    return view('Admin.privacypolicy.edit', compact('privacypolicy'));
}


    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Privacypolicy $privacypolicy)
{
    // Validation
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    // Update Data
    $privacypolicy->update([
        'title'       => $request->title,
        'description' => $request->description,
    ]);

    return redirect()->route('privacypolicy.index')
                     ->with('success', 'Privacy Policy updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Privacypolicy $privacypolicy)
{
    // Delete the record
    $privacypolicy->delete();

    // Redirect back with success message
    return redirect()->route('privacypolicy.index')
                     ->with('success', 'Privacy Policy deleted successfully.');
}

}
