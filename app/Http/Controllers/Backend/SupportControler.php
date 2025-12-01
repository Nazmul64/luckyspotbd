<?php

namespace App\Http\Controllers\Backend;

use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SupportControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supports_link=Support::all();
        return view('admin.Support.index',compact('supports_link'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Support.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'support_link'      => 'url',
        'title' => 'required|string|max:255',
        'photo'         => 'required|image|mimes:jpg,jpeg,webp,web,png,gif|max:2048',
        'status'        => 'required|in:active,inactive',
    ]);

    // Handle file upload
    $photoName = null;
    if ($request->hasFile('photo')) {
        $photoName = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads/supports'), $photoName);
    }

    // Save data
    Support::create([
        'support_link'      => $request->support_link,
        'title' => $request->title,
        'photo'         => $photoName,
        'status'        => $request->status,
    ]);

    return redirect()->route('supportlink.index')->with('success', 'supports  created successfully.');
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
        $supports_link=Support::find($id);
         return view('admin.Support.edit',compact('supports_link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $support = Support::findOrFail($id);
      // Prepare photo name

      // Handle new photo upload if provided

     if ($request->hasFile('new_photo')) {
            $file = $request->file('new_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/supports'), $filename);

            // Delete old image
            if ($support->photo && file_exists(public_path('uploads/supports/' . $support->photo))) {
                unlink(public_path('uploads/supports/' . $support->photo));
            }

            $support->photo = $filename;
        }




    // Update record
    $support->update([
        'support_link'=> $request->support_link,
        'title' => $request->title,
        'status'=> $request->status,
    ]);

    return redirect()->route('supportlink.index')->with('success', 'supportlink  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $supports = Support::findOrFail($id);

    // Delete photo from server if exists
    if ($supports->supports && file_exists(public_path('uploads/supports/' . $supports->photo))) {
        unlink(public_path('uploads/supports/' . $supports->photo));
    }

    // Delete record from database
    $supports->delete();

    return redirect()->route('supportlink.index')
                     ->with('success', 'supports  deleted successfully.');
    }

    // userdashboard support link
    public function supprtslinkshow(){
        $support=Support::all();
       return view('userdashboard.support.index',compact('support'));
    }
}
