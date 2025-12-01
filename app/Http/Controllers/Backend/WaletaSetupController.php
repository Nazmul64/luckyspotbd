<?php

namespace App\Http\Controllers\Backend;

use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\Waleta_setup;
use Illuminate\Http\Request;

class WaletaSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $walate = Waleta_setup::all();
        return view('admin.waletesetting.index',compact('walate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.waletesetting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'bankname'      => 'required|string|max:255',
        'accountnumber' => 'required|string|max:255',
        'photo'         => 'required|image|mimes:jpg,jpeg,webp,web,png,gif|max:2048',
        'status'        => 'required|in:active,inactive',
    ]);

    // Handle file upload
    $photoName = null;
    if ($request->hasFile('photo')) {
        $photoName = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads/waletesetting'), $photoName);
    }

    // Save data
    Waleta_setup::create([
        'bankname'      => $request->bankname,
        'accountnumber' => $request->accountnumber,
        'photo'         => $photoName,
        'status'        => $request->status,
    ]);

    return redirect()->route('waletesetting.index')->with('success', 'Wallet setting created successfully.');
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
       $Waleta_setup=Waleta_setup::find($id);
       return view('admin.waletesetting.edit',compact('Waleta_setup'));
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, $id)
{
    $Waleta_setup = Waleta_setup::findOrFail($id);

    // Validate inputs
    $request->validate([
        'bankname'      => 'required|string|max:255',
        'accountnumber' => 'required|string|max:255',
        'photo'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'status'        => 'required|in:active,inactive',
    ]);

    // Prepare photo name
    $photoName = $Waleta_setup->photo; // keep old photo by default

    // If new photo uploaded
    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        if ($Waleta_setup->photo && file_exists(public_path('uploads/waletesetting/' . $Waleta_setup->photo))) {
            unlink(public_path('uploads/waletesetting/' . $Waleta_setup->photo));
        }

        // Save new photo
        $photoName = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads/waletesetting'), $photoName);
    }

    // Update record
    $Waleta_setup->update([
        'bankname'      => $request->bankname,
        'accountnumber' => $request->accountnumber,
        'photo'         => $photoName,
        'status'        => $request->status,
    ]);

    return redirect()->route('waletesetting.index')->with('success', 'Wallet setting updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    $Waleta_setup = Waleta_setup::findOrFail($id);

    // Delete photo from server if exists
    if ($Waleta_setup->photo && file_exists(public_path('uploads/waletesetting/' . $Waleta_setup->photo))) {
        unlink(public_path('uploads/waletesetting/' . $Waleta_setup->photo));
    }

    // Delete record from database
    $Waleta_setup->delete();

    return redirect()->route('waletesetting.index')
                     ->with('success', 'Wallet setting deleted successfully.');
}

}
