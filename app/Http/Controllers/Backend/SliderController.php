<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Str;
use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slider=Slider::all();
        return view('admin.slider.index',compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */


public function store(Request $request)
{
    // Validate the form data
    $request->validate([
        'photo'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'status'      => 'required|in:0,1',
    ]);

    // Handle photo upload
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoName = Str::uuid() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('uploads/slider'), $photoName);
        $photoPath = 'uploads/slider/' . $photoName;
    }

    // Insert into database
    Slider::create([
        'title'       => $request->title,
        'description' => $request->description,
        'photo'       => $photoPath,
        'status'      => $request->status,
    ]);

    // Redirect with success message
    return redirect()->route('slider.index')->with('success', 'Slider created successfully!');
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
        $slider=Slider::find($id);
        return view('admin.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, $id)
{
    // Find the slider record
    $slider = Slider::findOrFail($id);

    // Prepare data for update
    $data = [
        'title'       => $request->title,
        'description' => $request->description,
        'status'      => $request->status,
    ];

    // Handle new photo upload if provided
    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        if ($slider->photo && File::exists(public_path($slider->photo))) {
            File::delete(public_path($slider->photo));
        }

        // Ensure upload directory exists
        $uploadPath = public_path('uploads/slider');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Save new photo
        $photo = $request->file('photo');
        $photoName = Str::uuid() . '.' . $photo->getClientOriginalExtension();
        $photo->move($uploadPath, $photoName);
        $data['photo'] = 'uploads/slider/' . $photoName;
    }

    // Update the record
    $slider->update($data);

    // Redirect back with success message
    return redirect()->route('slider.index')->with('success', 'Slider updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    // Find the slider by ID
    $slider = Slider::findOrFail($id);
    $slider->delete();

    // Redirect back with success message
    return redirect()->route('slider.index')->with('success', 'Slider deleted successfully!');
}
}
