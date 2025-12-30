<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testmonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testmonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'designation' => 'nullable|max:255',
            'message'     => 'required',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/testimonial'), $filename);
            $photoPath = 'uploads/testimonial/' . $filename;
        }

        Testimonial::create([
            'name'        => $request->name,
            'designation' => $request->designation,
            'message'     => $request->message,
            'photo'       => $photoPath,
        ]);

        return redirect()->route('testimonial.index')
            ->with('success', 'Testimonial added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testmonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'designation' => 'nullable|max:255',
            'message'     => 'required',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = $testimonial->photo;

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($testimonial->photo && file_exists(public_path($testimonial->photo))) {
                unlink(public_path($testimonial->photo));
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/testimonial'), $filename);
            $photoPath = 'uploads/testimonial/' . $filename;
        }

        $testimonial->update([
            'name'        => $request->name,
            'designation' => $request->designation,
            'message'     => $request->message,
            'photo'       => $photoPath,
        ]);

        return redirect()->route('testimonial.index')
            ->with('success', 'Testimonial updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo && file_exists(public_path($testimonial->photo))) {
            unlink(public_path($testimonial->photo));
        }

        $testimonial->delete();

        return redirect()->route('testimonial.index')
            ->with('success', 'Testimonial deleted successfully');
    }
}
