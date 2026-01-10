<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Waleta_setup;
use Illuminate\Http\Request;

class WaletaSetupController extends Controller
{
    // Index - List all wallet settings
    public function index()
    {
        $walates = Waleta_setup::all();
        return view('admin.waletesetting.index', compact('walates'));
    }

    // Create form
    public function create()
    {
        return view('admin.waletesetting.create');
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'bankname_en'      => 'required|string|max:255',
            'bankname_bn'      => 'required|string|max:255',
            'accountnumber_en' => 'required|string|max:255',
            'accountnumber_bn' => 'required|string|max:255',
            'photo'            => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'status'           => 'required|in:active,inactive',
        ]);

        // Handle photo upload
        $photoName = null;
        if ($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads/waletesetting'), $photoName);
        }

        // Save
        Waleta_setup::create([
            'bankname'      => ['en' => $request->bankname_en, 'bn' => $request->bankname_bn],
            'accountnumber' => ['en' => $request->accountnumber_en, 'bn' => $request->accountnumber_bn],
            'photo'         => $photoName,
            'status'        => $request->status,
        ]);

        return redirect()->route('waletesetting.index')->with('success', 'Wallet setting created successfully.');
    }

    // Edit form
    public function edit($id)
    {
        $walate = Waleta_setup::findOrFail($id);
        return view('admin.waletesetting.edit', compact('walate'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $walate = Waleta_setup::findOrFail($id);

        $request->validate([
            'bankname_en'      => 'required|string|max:255',
            'bankname_bn'      => 'required|string|max:255',
            'accountnumber_en' => 'required|string|max:255',
            'accountnumber_bn' => 'required|string|max:255',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'status'           => 'required|in:active,inactive',
        ]);

        // Handle photo
        $photoName = $walate->photo;
        if ($request->hasFile('photo')) {
            if ($walate->photo && file_exists(public_path('uploads/waletesetting/'.$walate->photo))) {
                unlink(public_path('uploads/waletesetting/'.$walate->photo));
            }
            $photoName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads/waletesetting'), $photoName);
        }

        $walate->update([
            'bankname'      => ['en' => $request->bankname_en, 'bn' => $request->bankname_bn],
            'accountnumber' => ['en' => $request->accountnumber_en, 'bn' => $request->accountnumber_bn],
            'photo'         => $photoName,
            'status'        => $request->status,
        ]);

        return redirect()->route('waletesetting.index')->with('success', 'Wallet setting updated successfully.');
    }

    // Delete
    public function destroy($id)
    {
        $walate = Waleta_setup::findOrFail($id);

        if ($walate->photo && file_exists(public_path('uploads/waletesetting/'.$walate->photo))) {
            unlink(public_path('uploads/waletesetting/'.$walate->photo));
        }

        $walate->delete();

        return redirect()->route('waletesetting.index')->with('success', 'Wallet setting deleted successfully.');
    }
}
