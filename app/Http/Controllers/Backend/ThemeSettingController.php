<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\cr;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;

class ThemeSettingController extends Controller
{
    /**
     * Display all theme settings
     */
    public function index()
    {
        $themes =ThemeSetting::latest()->get();
        return view('admin.theme.index', compact('themes'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.theme.create');
    }

    /**
     * Store new theme setting
     */
    public function store(Request $request)
    {
        $request->validate([
            'primary_color'   => 'required|string',
            'secondary_color' => 'required|string',
            'status'          => 'required|boolean',
        ]);

        // Optional: Only one active theme
        if ($request->status == 1) {
            ThemeSetting::where('status', 1)->update(['status' => 0]);
        }

        ThemeSetting::create([
            'primary_color'   => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'status'          => $request->status,
        ]);

        return redirect()
            ->route('theme.index')
            ->with('success', 'Theme created successfully');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $theme = ThemeSetting::findOrFail($id);
        return view('admin.theme.edit', compact('theme'));
    }

    /**
     * Update theme setting
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'primary_color'   => 'required|string',
            'secondary_color' => 'required|string',
            'status'          => 'required|boolean',
        ]);

        // Optional: Only one active theme
        if ($request->status == 1) {
            ThemeSetting::where('status', 1)
              ->where('id', '!=', $id)
              ->update(['status' => 0]);
        }

        $theme = ThemeSetting::findOrFail($id);
        $theme->update([
            'primary_color'   => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'status'          => $request->status,
        ]);

        return redirect()
            ->route('theme.index')
            ->with('success', 'Theme updated successfully');
    }

    /**
     * Delete theme
     */
    public function destroy($id)
    {
        ThemeSetting::findOrFail($id)->delete();

        return redirect()
            ->route('theme.index')
            ->with('success', 'Theme deleted successfully');
    }
}
