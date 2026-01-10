<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slider = Slider::latest()->get();
        return view('admin.slider.index', compact('slider'));
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
        // ✅ Multilingual Validation
        $request->validate([
            'title_en'       => 'required|string|max:255',
            'title_bn'       => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
            'photo'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:0,1',
        ], [
            'title_en.required' => 'English title is required',
            'title_bn.required' => 'Bangla title is required',
            'description_en.required' => 'English description is required',
            'description_bn.required' => 'Bangla description is required',
            'photo.required' => 'Photo is required',
        ]);

        // Ensure upload directory exists
        $uploadPath = public_path('uploads/slider');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Upload photo
        $photoName = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $photo->move($uploadPath, $photoName);
        }

        // ✅ Create slider with multilingual data
        Slider::create([
            'title' => [
                'en' => $request->title_en,
                'bn' => $request->title_bn,
            ],
            'description' => [
                'en' => $request->description_en,
                'bn' => $request->description_bn,
            ],
            'photo'  => 'uploads/slider/' . $photoName,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('slider.index')
            ->with('success', 'Slider created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        // ✅ Multilingual Validation
        $request->validate([
            'title_en'       => 'required|string|max:255',
            'title_bn'       => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:0,1',
        ], [
            'title_en.required' => 'English title is required',
            'title_bn.required' => 'Bangla title is required',
            'description_en.required' => 'English description is required',
            'description_bn.required' => 'Bangla description is required',
        ]);

        // ✅ Prepare multilingual data
        $data = [
            'title' => [
                'en' => $request->title_en,
                'bn' => $request->title_bn,
            ],
            'description' => [
                'en' => $request->description_en,
                'bn' => $request->description_bn,
            ],
            'status' => $request->status,
        ];

        // Handle photo update
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($slider->photo && File::exists(public_path($slider->photo))) {
                File::delete(public_path($slider->photo));
            }

            $uploadPath = public_path('uploads/slider');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $photo = $request->file('photo');
            $photoName = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $photo->move($uploadPath, $photoName);

            $data['photo'] = 'uploads/slider/' . $photoName;
        }

        $slider->update($data);

        return redirect()
            ->route('slider.index')
            ->with('success', 'Slider updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // Delete photo from storage
        if ($slider->photo && File::exists(public_path($slider->photo))) {
            File::delete(public_path($slider->photo));
        }

        $slider->delete();

        return redirect()
            ->route('slider.index')
            ->with('success', 'Slider deleted successfully!');
    }
}
