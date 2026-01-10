<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Exception;

class LotterycreateController extends Controller
{
    /**
     * Display a listing of lotteries
     */
    public function index()
    {
        try {
            $lotteries = Lottery::latest()->get();
            return view('admin.lottery.index', compact('lotteries'));
        } catch (Exception $e) {
            Log::error('Lottery Index Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load lotteries.');
        }
    }

    /**
     * Show the form for creating a new lottery
     */
    public function create()
    {
        return view('admin.lottery.create');
    }

    /**
     * Store a newly created lottery in storage
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'description_en' => 'nullable|string|max:5000',
            'description_bn' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'first_prize' => 'nullable|numeric|min:0',
            'second_prize' => 'nullable|numeric|min:0',
            'third_prize' => 'nullable|numeric|min:0',
            'multiple_title' => 'nullable|array',
            'multiple_title.*' => 'nullable|string|max:255',
            'multiple_price' => 'nullable|array',
            'multiple_price.*' => 'nullable|numeric|min:0',
            'video_url' => 'nullable|url|max:500',
            'video_enabled' => 'nullable|boolean',
            'video_scheduled_at' => 'nullable|date',
            'draw_date' => 'required|date|after:now',
            'win_type' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,completed',
        ]);

        try {
            // ✅ Prepare data - NO json_encode() needed because Model has 'array' cast
            $data = [
                'name' => [
                    'en' => $request->name_en,
                    'bn' => $request->name_bn,
                ],
                'description' => [
                    'en' => $request->description_en ?? '',
                    'bn' => $request->description_bn ?? '',
                ],
                'price' => $request->price,
                'first_prize' => $request->first_prize ?? 0,
                'second_prize' => $request->second_prize ?? 0,
                'third_prize' => $request->third_prize ?? 0,
                'video_url' => $request->video_url,
                'video_enabled' => $request->has('video_enabled') ? 1 : 0,
                'video_scheduled_at' => $request->video_scheduled_at,
                'draw_date' => $request->draw_date,
                'win_type' => $request->win_type,
                'status' => $request->status,
            ];

            // Handle multiple packages - also as array (Model will auto-encode to JSON)
            if ($request->has('multiple_title') && is_array($request->multiple_title)) {
                $titles = array_filter($request->multiple_title, function($title) {
                    return !empty(trim($title));
                });

                $prices = [];
                foreach ($titles as $key => $title) {
                    $prices[$key] = $request->multiple_price[$key] ?? 0;
                }

                // Store as arrays - Model will handle JSON encoding
                $data['multiple_title'] = array_values($titles);
                $data['multiple_price'] = array_values($prices);
            } else {
                $data['multiple_title'] = [];
                $data['multiple_price'] = [];
            }

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $data['photo'] = $this->uploadPhoto($request->file('photo'));
            }

            // Create lottery
            $lottery = Lottery::create($data);

            Log::info('✅ Lottery Created Successfully', [
                'id' => $lottery->id,
                'name' => $lottery->name, // This will log as array
            ]);

            return redirect()
                ->route('lottery.index')
                ->with('success', '✅ Lottery created successfully!');

        } catch (Exception $e) {
            Log::error('❌ Lottery Store Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', '❌ Failed to create lottery: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified lottery
     */
    public function edit($id)
    {
        try {
            $lottery = Lottery::findOrFail($id);
            return view('admin.lottery.edit', compact('lottery'));
        } catch (Exception $e) {
            Log::error('Lottery Edit Error: ' . $e->getMessage());
            return redirect()
                ->route('lottery.index')
                ->with('error', '❌ Lottery not found.');
        }
    }

    /**
     * Update the specified lottery in storage
     */
    public function update(Request $request, $id)
    {
        try {
            $lottery = Lottery::findOrFail($id);
        } catch (Exception $e) {
            return redirect()
                ->route('lottery.index')
                ->with('error', '❌ Lottery not found.');
        }

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'description_en' => 'nullable|string|max:5000',
            'description_bn' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0',
            'new_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'first_prize' => 'nullable|numeric|min:0',
            'second_prize' => 'nullable|numeric|min:0',
            'third_prize' => 'nullable|numeric|min:0',
            'multiple_title' => 'nullable|array',
            'multiple_title.*' => 'nullable|string|max:255',
            'multiple_price' => 'nullable|array',
            'multiple_price.*' => 'nullable|numeric|min:0',
            'video_url' => 'nullable|url|max:500',
            'video_enabled' => 'nullable|boolean',
            'video_scheduled_at' => 'nullable|date',
            'draw_date' => 'required|date',
            'win_type' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,completed',
        ]);

        try {
            // ✅ Prepare data - NO json_encode() needed
            $data = [
                'name' => [
                    'en' => $request->name_en,
                    'bn' => $request->name_bn,
                ],
                'description' => [
                    'en' => $request->description_en ?? '',
                    'bn' => $request->description_bn ?? '',
                ],
                'price' => $request->price,
                'first_prize' => $request->first_prize ?? 0,
                'second_prize' => $request->second_prize ?? 0,
                'third_prize' => $request->third_prize ?? 0,
                'video_url' => $request->video_url,
                'video_enabled' => $request->has('video_enabled') ? 1 : 0,
                'video_scheduled_at' => $request->video_scheduled_at,
                'draw_date' => $request->draw_date,
                'win_type' => $request->win_type,
                'status' => $request->status,
            ];

            // Handle multiple packages
            if ($request->has('multiple_title') && is_array($request->multiple_title)) {
                $titles = array_filter($request->multiple_title, function($title) {
                    return !empty(trim($title));
                });

                $prices = [];
                foreach ($titles as $key => $title) {
                    $prices[$key] = $request->multiple_price[$key] ?? 0;
                }

                $data['multiple_title'] = array_values($titles);
                $data['multiple_price'] = array_values($prices);
            } else {
                $data['multiple_title'] = [];
                $data['multiple_price'] = [];
            }

            // Handle photo upload
            if ($request->hasFile('new_photo')) {
                if ($lottery->photo) {
                    $this->deletePhoto($lottery->photo);
                }
                $data['photo'] = $this->uploadPhoto($request->file('new_photo'));
            }

            // Update lottery
            $lottery->update($data);

            Log::info('✅ Lottery Updated Successfully', [
                'id' => $lottery->id,
                'name' => $lottery->name,
            ]);

            return redirect()
                ->route('lottery.index')
                ->with('success', '✅ Lottery updated successfully!');

        } catch (Exception $e) {
            Log::error('❌ Lottery Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', '❌ Failed to update lottery: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified lottery from storage
     */
    public function destroy($id)
    {
        try {
            $lottery = Lottery::findOrFail($id);

            if ($lottery->photo) {
                $this->deletePhoto($lottery->photo);
            }

            $lottery->delete();

            Log::info('✅ Lottery Deleted', ['id' => $id]);

            return redirect()
                ->route('lottery.index')
                ->with('success', '✅ Lottery deleted successfully!');

        } catch (Exception $e) {
            Log::error('❌ Lottery Delete Error: ' . $e->getMessage());
            return back()->with('error', '❌ Failed to delete lottery.');
        }
    }

    /**
     * Upload photo to storage
     */
    private function uploadPhoto($file)
    {
        try {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/lottery');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);

            Log::info('✅ Photo Uploaded', ['filename' => $filename]);

            return $filename;
        } catch (Exception $e) {
            Log::error('Photo Upload Error: ' . $e->getMessage());
            throw new Exception('Failed to upload photo.');
        }
    }

    /**
     * Delete photo from storage
     */
    private function deletePhoto($filename)
    {
        try {
            if (!$filename) return false;

            $filePath = public_path('uploads/lottery/' . $filename);

            if (File::exists($filePath)) {
                File::delete($filePath);
                Log::info('✅ Photo Deleted', ['filename' => $filename]);
                return true;
            }

            return false;
        } catch (Exception $e) {
            Log::error('Photo Delete Error: ' . $e->getMessage());
            return false;
        }
    }
}
