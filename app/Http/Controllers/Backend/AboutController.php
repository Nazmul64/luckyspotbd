<?php

namespace App\Http\Controllers\Backend;

use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutus =About::all();
        return view('admin.aboutus.index', compact('aboutus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.aboutus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // ভ্যালিডেশন
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB max
    ]);

    $about = new \App\Models\About();
    $about->title = $request->title;
    $about->description = $request->description;
    $about->status = $request->status ?? 1; // যদি status না আসে, 1 সেট হবে

    // ছবি আপলোড
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/aboutus'), $filename);
        $about->photo = 'uploads/aboutus/' . $filename;
    }

    $about->save();

    return redirect()->back()->with('success', 'About Us data saved successfully!');
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
        $about = About::find($id);
        return view('admin.aboutus.edit', compact('about'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB max
        ]);

        $about = About::find($id);
        $about->title = $request->title;
        $about->description = $request->description;
        $about->status = $request->status ?? 1; // যদি status না আসে, 1 সেট হবে

        // ছবি আপলোড
        if ($request->hasFile('new_photo')) {
            // পুরানো ছবি মুছে ফেলা (যদি থাকে)
            if ($about->photo && file_exists(public_path($about->photo))) {
                unlink(public_path($about->photo));
            }

            $file = $request->file('new_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/aboutus'), $filename);
            $about->photo = 'uploads/aboutus/' . $filename;
        }

        $about->save();

        return redirect()->back()->with('success', 'About Us data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $about = About::find($id);
        if ($about) {
            // পুরানো ছবি মুছে ফেলা (যদি থাকে)
            if ($about->photo && file_exists(public_path($about->photo))) {
                unlink(public_path($about->photo));
            }
            $about->delete();
            return redirect()->back()->with('success', 'About Us data deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'About Us data not found!');
        }
    }
}
