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

    public function create()
    {
        return view('admin.lottery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:5000',
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
            'video_scheduled_at' => 'nullable|date|after:now',
            'status' => 'required|in:active,inactive,completed',
            'draw_date' => 'required|date|after:now',
            'win_type' => 'required|string|max:50',
        ]);

        try {
            $data = $validated;
            $data['video_enabled'] = $request->has('video_enabled') ? 1 : 0;

            // Clean packages
            if (isset($data['multiple_title']) && is_array($data['multiple_title'])) {
                $cleanTitles = [];
                $cleanPrices = [];

                foreach ($data['multiple_title'] as $index => $title) {
                    $trimmedTitle = trim($title ?? '');
                    if (!empty($trimmedTitle)) {
                        $cleanTitles[] = $trimmedTitle;
                        $cleanPrices[] = floatval($data['multiple_price'][$index] ?? 0);
                    }
                }

                $data['multiple_title'] = !empty($cleanTitles) ? $cleanTitles : null;
                $data['multiple_price'] = !empty($cleanPrices) ? $cleanPrices : null;
            } else {
                $data['multiple_title'] = null;
                $data['multiple_price'] = null;
            }

            // Upload photo
            if ($request->hasFile('photo')) {
                $data['photo'] = $this->uploadPhoto($request->file('photo'));
            }

            // ⭐ CRITICAL: Convert Bangladesh time to UTC for database storage
            if (!empty($data['video_scheduled_at'])) {
                // User enters Bangladesh time (BST = UTC+6)
                // We need to convert to UTC for database
                $bstTime = Carbon::parse($data['video_scheduled_at'], 'Asia/Dhaka');
                $data['video_scheduled_at'] = $bstTime->setTimezone('UTC')->format('Y-m-d H:i:s');

                Log::info('Video Scheduled Time Conversion', [
                    'input_bst' => $request->input('video_scheduled_at'),
                    'parsed_bst' => $bstTime->format('Y-m-d H:i:s'),
                    'saved_utc' => $data['video_scheduled_at'],
                ]);
            }

            if (!empty($data['draw_date'])) {
                // User enters Bangladesh time (BST = UTC+6)
                // We need to convert to UTC for database
                $bstTime = Carbon::parse($data['draw_date'], 'Asia/Dhaka');
                $data['draw_date'] = $bstTime->setTimezone('UTC')->format('Y-m-d H:i:s');

                Log::info('Draw Date Conversion', [
                    'input_bst' => $request->input('draw_date'),
                    'parsed_bst' => $bstTime->format('Y-m-d H:i:s'),
                    'saved_utc' => $data['draw_date'],
                ]);
            }

            $lottery = Lottery::create($data);

            Log::info('✅ Lottery Created Successfully', [
                'id' => $lottery->id,
                'name' => $lottery->name,
                'video_scheduled_at_utc' => $data['video_scheduled_at'] ?? null,
                'draw_date_utc' => $data['draw_date'],
            ]);

            return redirect()
                ->route('lottery.index')
                ->with('success', '✅ Lottery created successfully!');

        } catch (Exception $e) {
            Log::error('❌ Lottery Store Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());

            if (isset($data['photo'])) {
                $this->deletePhoto($data['photo']);
            }

            return back()
                ->withInput()
                ->with('error', '❌ Failed to create lottery: ' . $e->getMessage());
        }
    }

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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:5000',
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
            'status' => 'required|in:active,inactive,completed',
            'draw_date' => 'required|date',
            'win_type' => 'required|string|max:50',
        ]);

        try {
            $data = $validated;
            $data['video_enabled'] = $request->has('video_enabled') ? 1 : 0;

            // Clean packages
            if (isset($data['multiple_title']) && is_array($data['multiple_title'])) {
                $cleanTitles = [];
                $cleanPrices = [];

                foreach ($data['multiple_title'] as $index => $title) {
                    $trimmedTitle = trim($title ?? '');
                    if (!empty($trimmedTitle)) {
                        $cleanTitles[] = $trimmedTitle;
                        $cleanPrices[] = floatval($data['multiple_price'][$index] ?? 0);
                    }
                }

                $data['multiple_title'] = !empty($cleanTitles) ? $cleanTitles : null;
                $data['multiple_price'] = !empty($cleanPrices) ? $cleanPrices : null;
            } else {
                $data['multiple_title'] = null;
                $data['multiple_price'] = null;
            }

            // Handle new photo
            if ($request->hasFile('new_photo')) {
                if ($lottery->photo) {
                    $this->deletePhoto($lottery->photo);
                }
                $data['photo'] = $this->uploadPhoto($request->file('new_photo'));
            }

            // ⭐ CRITICAL: Convert Bangladesh time to UTC for database
            if (!empty($data['video_scheduled_at'])) {
                $bstTime = Carbon::parse($data['video_scheduled_at'], 'Asia/Dhaka');
                $data['video_scheduled_at'] = $bstTime->setTimezone('UTC')->format('Y-m-d H:i:s');

                Log::info('Video Scheduled Time Update', [
                    'input_bst' => $request->input('video_scheduled_at'),
                    'saved_utc' => $data['video_scheduled_at'],
                ]);
            }

            if (!empty($data['draw_date'])) {
                $bstTime = Carbon::parse($data['draw_date'], 'Asia/Dhaka');
                $data['draw_date'] = $bstTime->setTimezone('UTC')->format('Y-m-d H:i:s');

                Log::info('Draw Date Update', [
                    'input_bst' => $request->input('draw_date'),
                    'saved_utc' => $data['draw_date'],
                ]);
            }

            unset($data['new_photo']);
            $lottery->update($data);

            Log::info('✅ Lottery Updated Successfully', [
                'id' => $lottery->id,
                'video_scheduled_at_utc' => $data['video_scheduled_at'] ?? null,
            ]);

            return redirect()
                ->route('lottery.index')
                ->with('success', '✅ Lottery updated successfully!');

        } catch (Exception $e) {
            Log::error('❌ Lottery Update Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());

            if (isset($data['photo']) && $data['photo'] !== $lottery->photo) {
                $this->deletePhoto($data['photo']);
            }

            return back()
                ->withInput()
                ->with('error', '❌ Failed to update lottery: ' . $e->getMessage());
        }
    }

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

    private function uploadPhoto($file)
    {
        try {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/lottery');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            return $filename;
        } catch (Exception $e) {
            Log::error('Photo Upload Error: ' . $e->getMessage());
            throw new Exception('Failed to upload photo.');
        }
    }

    private function deletePhoto($filename)
    {
        try {
            if (!$filename) return false;

            $filePath = public_path('uploads/lottery/' . $filename);

            if (File::exists($filePath)) {
                File::delete($filePath);
                return true;
            }

            return false;
        } catch (Exception $e) {
            Log::error('Photo Delete Error: ' . $e->getMessage());
            return false;
        }
    }

    public function statistics()
    {
        try {
            $stats = [
                'total' => Lottery::count(),
                'active' => Lottery::where('status', 'active')->count(),
                'inactive' => Lottery::where('status', 'inactive')->count(),
                'completed' => Lottery::where('status', 'completed')->count(),
                'upcoming' => Lottery::where('draw_date', '>', Carbon::now('Asia/Dhaka'))->count(),
                'today' => Lottery::whereDate('draw_date', Carbon::today('Asia/Dhaka'))->count(),
            ];

            return response()->json($stats);
        } catch (Exception $e) {
            Log::error('Lottery Statistics Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get statistics'], 500);
        }
    }
}
