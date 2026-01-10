<?php
// app/Http/Controllers/Backend/WhychooseusticketController.php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Whychooseusticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class WhychooseusticketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tickets = Whychooseusticket::latest()->get();
            return view('admin.whychooseustickets.index', compact('tickets'));
        } catch (Exception $e) {
            Log::error('Why Choose Us Index Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.whychooseustickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_title_en' => 'nullable|string|max:255',
            'main_title_bn' => 'nullable|string|max:255',
            'main_description_en' => 'nullable|string',
            'main_description_bn' => 'nullable|string',
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        try {
            // ✅ Prepare multilingual data - NO json_encode() needed
            $data = [
                'main_title' => [
                    'en' => $request->main_title_en ?? '',
                    'bn' => $request->main_title_bn ?? '',
                ],
                'main_description' => [
                    'en' => $request->main_description_en ?? '',
                    'bn' => $request->main_description_bn ?? '',
                ],
                'title' => [
                    'en' => $request->title_en ?? '',
                    'bn' => $request->title_bn ?? '',
                ],
                'description' => [
                    'en' => $request->description_en ?? '',
                    'bn' => $request->description_bn ?? '',
                ],
                'icon' => $request->icon,
            ];

            Whychooseusticket::create($data);

            Log::info('✅ Why Choose Us Item Created Successfully');

            return redirect()
                ->route('whychooseustickets.index')
                ->with('success', '✅ Item added successfully!');

        } catch (Exception $e) {
            Log::error('❌ Why Choose Us Store Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', '❌ Failed to add item: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Whychooseusticket $whychooseusticket)
    {
        return view('admin.whychooseustickets.edit', [
            'ticket' => $whychooseusticket
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Whychooseusticket $whychooseusticket)
    {
        $validated = $request->validate([
            'main_title_en' => 'nullable|string|max:255',
            'main_title_bn' => 'nullable|string|max:255',
            'main_description_en' => 'nullable|string',
            'main_description_bn' => 'nullable|string',
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        try {
            // ✅ Prepare multilingual data - NO json_encode() needed
            $data = [
                'main_title' => [
                    'en' => $request->main_title_en ?? '',
                    'bn' => $request->main_title_bn ?? '',
                ],
                'main_description' => [
                    'en' => $request->main_description_en ?? '',
                    'bn' => $request->main_description_bn ?? '',
                ],
                'title' => [
                    'en' => $request->title_en ?? '',
                    'bn' => $request->title_bn ?? '',
                ],
                'description' => [
                    'en' => $request->description_en ?? '',
                    'bn' => $request->description_bn ?? '',
                ],
                'icon' => $request->icon,
            ];

            $whychooseusticket->update($data);

            Log::info('✅ Why Choose Us Item Updated Successfully', ['id' => $whychooseusticket->id]);

            return redirect()
                ->route('whychooseustickets.index')
                ->with('success', '✅ Item updated successfully!');

        } catch (Exception $e) {
            Log::error('❌ Why Choose Us Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', '❌ Failed to update item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Whychooseusticket $whychooseusticket)
    {
        try {
            $whychooseusticket->delete();

            Log::info('✅ Why Choose Us Item Deleted', ['id' => $whychooseusticket->id]);

            return redirect()
                ->route('whychooseustickets.index')
                ->with('success', '✅ Item deleted successfully!');

        } catch (Exception $e) {
            Log::error('❌ Why Choose Us Delete Error: ' . $e->getMessage());

            return back()->with('error', '❌ Failed to delete item.');
        }
    }
}
