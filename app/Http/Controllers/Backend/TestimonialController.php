<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testmonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testmonial.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en'    => 'required|max:255',
            'name_bn'    => 'nullable|max:255',
            'designation_en' => 'nullable|max:255',
            'designation_bn' => 'nullable|max:255',
            'message_en' => 'required',
            'message_bn' => 'nullable',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title_en'   => 'nullable|max:255',
            'title_bn'   => 'nullable|max:255',
            'description_en' => 'nullable|max:255',
            'description_bn' => 'nullable|max:255',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/testimonial'), $filename);
            $photoPath = 'uploads/testimonial/' . $filename;
        }

        Testimonial::create([
            'name'        => ['en' => $request->name_en, 'bn' => $request->name_bn],
            'designation' => ['en' => $request->designation_en, 'bn' => $request->designation_bn],
            'message'     => ['en' => $request->message_en, 'bn' => $request->message_bn],
            'title'       => ['en' => $request->title_en, 'bn' => $request->title_bn],
            'description' => ['en' => $request->description_en, 'bn' => $request->description_bn],
            'photo'       => $photoPath,
        ]);

        return redirect()->route('testimonial.index')
            ->with('success', 'Testimonial added successfully');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testmonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name_en'    => 'required|max:255',
            'name_bn'    => 'nullable|max:255',
            'designation_en' => 'nullable|max:255',
            'designation_bn' => 'nullable|max:255',
            'message_en' => 'required',
            'message_bn' => 'nullable',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title_en'   => 'nullable|max:255',
            'title_bn'   => 'nullable|max:255',
            'description_en' => 'nullable|max:255',
            'description_bn' => 'nullable|max:255',
        ]);

        $photoPath = $testimonial->photo;

        if ($request->hasFile('photo')) {
            if ($testimonial->photo && file_exists(public_path($testimonial->photo))) {
                unlink(public_path($testimonial->photo));
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/testimonial'), $filename);
            $photoPath = 'uploads/testimonial/' . $filename;
        }

        $testimonial->update([
            'name'        => ['en' => $request->name_en, 'bn' => $request->name_bn],
            'designation' => ['en' => $request->designation_en, 'bn' => $request->designation_bn],
            'message'     => ['en' => $request->message_en, 'bn' => $request->message_bn],
            'title'       => ['en' => $request->title_en, 'bn' => $request->title_bn],
            'description' => ['en' => $request->description_en, 'bn' => $request->description_bn],
            'photo'       => $photoPath,
        ]);

        return redirect()->route('testimonial.index')
            ->with('success', 'Testimonial updated successfully');
    }

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
