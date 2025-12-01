<?php

namespace App\Http\Controllers\Backend;

use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $settings = Setting::all();
    return view('admin.setting.index', compact('settings'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.setting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    // Validation
    $request->validate([
        'photo'        => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp,web|max:2048',
        'favicon'      => 'nullable|image|mimes:ico,webp,web,png|max:2048',
        'phone'        => 'required|string|max:20',
        'email'        => 'required|email|max:100',
        'address'      => 'required|string|max:255',
        'facebook'     => 'nullable|url|max:255',
        'twitter'      => 'nullable|url|max:255',
        'linkedin'     => 'nullable|url|max:255',
        'instagram'    => 'nullable|url|max:255',
        'tilegram'     => 'nullable|url|max:255',
        'youtube'      => 'nullable|url|max:255',
        'footer_about' => 'nullable|string',
        'footer_text'  => 'nullable|string',
    ]);

    $data = $request->all();

    // Photo Upload
    if($request->hasFile('photo')) {
        $photoName = time().'_'.$request->photo->getClientOriginalName();
        $request->photo->move(public_path('uploads/settings'), $photoName);
        $data['photo'] = $photoName;
    }

    // Favicon Upload
    if($request->hasFile('favicon')) {
        $faviconName = time().'_'.$request->favicon->getClientOriginalName();
        $request->favicon->move(public_path('uploads/settings'), $faviconName);
        $data['favicon'] = $faviconName;
    }

    // Create Setting
    Setting::create($data);

    return redirect()->route('settings.index')->with('success', 'Settings created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('admin.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, $id)
{
    // Find the setting
    $setting = Setting::findOrFail($id);

    // Validation
    $request->validate([
        'photo'        => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        'favicon'      => 'nullable|image|mimes:ico,png|max:1024',
        'phone'        => 'required|string|max:20',
        'email'        => 'required|email|max:100',
        'address'      => 'required|string|max:255',
        'facebook'     => 'nullable|url|max:255',
        'twitter'      => 'nullable|url|max:255',
        'linkedin'     => 'nullable|url|max:255',
        'instagram'    => 'nullable|url|max:255',
        'tilegram'     => 'nullable|url|max:255',
        'youtube'      => 'nullable|url|max:255',
        'footer_about' => 'nullable|string',
        'footer_text'  => 'nullable|string',
    ]);

    $data = $request->all();

    // Photo Upload
    if ($request->hasFile('photo')) {
        // Remove old photo
        if ($setting->photo && file_exists(public_path('uploads/settings/' . $setting->photo))) {
            unlink(public_path('uploads/settings/' . $setting->photo));
        }

        $photoName = time() . '_' . $request->photo->getClientOriginalName();
        $request->photo->move(public_path('uploads/settings'), $photoName);
        $data['photo'] = $photoName;
    }

    // Favicon Upload
    if ($request->hasFile('favicon')) {
        // Remove old favicon
        if ($setting->favicon && file_exists(public_path('uploads/settings/' . $setting->favicon))) {
            unlink(public_path('uploads/settings/' . $setting->favicon));
        }

        $faviconName = time() . '_' . $request->favicon->getClientOriginalName();
        $request->favicon->move(public_path('uploads/settings'), $faviconName);
        $data['favicon'] = $faviconName;
    }

    // Update Setting
    $setting->update($data);

    return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);

        // Remove photo
        if ($setting->photo && file_exists(public_path('uploads/settings/' . $setting->photo))) {
            unlink(public_path('uploads/settings/' . $setting->photo));
        }

        // Remove favicon
        if ($setting->favicon && file_exists(public_path('uploads/settings/' . $setting->favicon))) {
            unlink(public_path('uploads/settings/' . $setting->favicon));
        }

        $setting->delete();

        return redirect()->route('settings.index')->with('success', 'Settings deleted successfully.');
    }
}
