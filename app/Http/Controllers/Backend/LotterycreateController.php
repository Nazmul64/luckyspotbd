<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\Rule;

class LotterycreateController extends Controller
{
    // Constants
    private const PHOTO_MAX_SIZE = 2048; // KB
    private const VIDEO_MAX_SIZE = 512000; // KB
    private const PAGINATION = 15;
    private const PHOTO_DIR = 'uploads/lottery';
    private const VIDEO_DIR = 'uploads/lottery/videos';

    /**
     * Display lottery list with pagination
     */
    public function index()
    {

            $lotteries = Lottery::latest('id')->paginate(self::PAGINATION);
            return view('admin.Lottery.index', compact('lotteries'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.lottery.create');
    }

    /**
     * Store new lottery
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                ->with('error', 'Please fix validation errors.');
        }

        DB::beginTransaction();

        try {
            $data = $this->prepareData($request);

            // Handle uploads
            if ($request->hasFile('photo')) {
                $data['photo'] = $this->uploadFile($request->file('photo'), self::PHOTO_DIR);
            }

            $this->processVideo($request, $data);

            $lottery = Lottery::create($data);

            DB::commit();

            Log::info('Lottery Created', ['id' => $lottery->id]);

            return redirect()->route('lottery.index')
                ->with('success', 'Lottery created successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            $this->cleanup($data ?? []);

            Log::error('Lottery Store Failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to create lottery: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {

            $lottery = Lottery::findOrFail($id);
            return view('admin.Lottery.edit', compact('lottery'));

    }

    /**
     * Update lottery
     */
    public function update(Request $request, $id)
    {
        try {
            $lottery = Lottery::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('lottery.index')
                ->with('error', 'Lottery not found.');
        }

        $validator = $this->validator($request, $lottery);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                ->with('error', 'Please fix validation errors.');
        }

        DB::beginTransaction();

        try {
            $oldPhoto = $lottery->photo;
            $oldVideo = $lottery->video_file;

            $data = $this->prepareData($request);

            // Handle photo update
            if ($request->hasFile('new_photo')) {
                $data['photo'] = $this->uploadFile($request->file('new_photo'), self::PHOTO_DIR);
                $this->deleteFile($oldPhoto, self::PHOTO_DIR);
            } else {
                $data['photo'] = $lottery->photo;
            }

            // Handle video update
            $this->processVideoUpdate($request, $lottery, $data, $oldVideo);

            $lottery->update($data);

            DB::commit();

            Log::info('Lottery Updated', ['id' => $lottery->id]);

            return redirect()->route('lottery.index')
                ->with('success', 'Lottery updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            $this->cleanup($data ?? []);

            Log::error('Lottery Update Failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to update lottery: ' . $e->getMessage());
        }
    }

    /**
     * Delete lottery
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $lottery = Lottery::findOrFail($id);

            $photo = $lottery->photo;
            $video = $lottery->video_file;

            $lottery->delete();

            $this->deleteFile($photo, self::PHOTO_DIR);
            $this->deleteFile($video, self::VIDEO_DIR);

            DB::commit();

            Log::info('Lottery Deleted', ['id' => $id]);

            return redirect()->route('lottery.index')
                ->with('success', 'Lottery deleted successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Lottery Delete Failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete lottery.');
        }
    }

    // ==========================================
    // PRIVATE HELPER METHODS
    // ==========================================

    /**
     * Validate request
     */
    private function validator(Request $request, ?Lottery $lottery = null)
    {
        $isUpdate = !is_null($lottery);

        $rules = [
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'description_en' => 'nullable|string|max:5000',
            'description_bn' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0|max:999999999',
            'first_prize' => 'nullable|numeric|min:0|max:999999999',
            'second_prize' => 'nullable|numeric|min:0|max:999999999',
            'third_prize' => 'nullable|numeric|min:0|max:999999999',
            'video_enabled' => 'nullable|boolean',
            'video_type' => ['required', Rule::in(['upload', 'direct', 'youtube'])],
            'video_scheduled_at' => 'nullable|date|after_or_equal:now',
            'draw_date' => 'required|date|after:now',
            'win_type' => 'required|string|max:50',
            'status' => ['required', Rule::in(['active', 'inactive', 'completed'])],
        ];

        // Photo rules
        $photoRule = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:' . self::PHOTO_MAX_SIZE;
        $rules[$isUpdate ? 'new_photo' : 'photo'] = $photoRule;

        // Video rules
        if ($request->input('video_enabled')) {
            $videoType = $request->input('video_type');

            if ($videoType === 'upload') {
                $required = $isUpdate ? 'nullable' : 'required';
                $rules['video_file'] = $required . '|file|mimes:mp4,webm,ogg,mov|max:' . self::VIDEO_MAX_SIZE;
            } elseif ($videoType === 'direct') {
                $rules['video_url_direct'] = 'required|url|max:500';
            } elseif ($videoType === 'youtube') {
                $rules['video_url_youtube'] = 'required|string|max:200';
            }
        }

        return Validator::make($request->all(), $rules, [
            'name_en.required' => 'English name is required',
            'name_bn.required' => 'Bengali name is required',
            'price.required' => 'Price is required',
            'draw_date.after' => 'Draw date must be in future',
            'video_file.required' => 'Video file required',
            'video_file.max' => 'Video max 500MB',
        ]);
    }

    /**
     * Prepare lottery data
     */
    private function prepareData(Request $request): array
    {
        return [
            'name' => [
                'en' => $request->name_en,
                'bn' => $request->name_bn,
            ],
            'description' => [
                'en' => $request->description_en ?? '',
                'bn' => $request->description_bn ?? '',
            ],
            'price' => $request->price ?? 0,
            'first_prize' => $request->first_prize ?? 0,
            'second_prize' => $request->second_prize ?? 0,
            'third_prize' => $request->third_prize ?? 0,
            'multiple_title' => $this->filterArray($request->multiple_title ?? []),
            'multiple_price' => $this->filterPrices($request->multiple_price ?? []),
            'video_enabled' => $request->has('video_enabled'),
            'video_type' => $request->video_type ?? 'direct',
            'video_scheduled_at' => $request->video_scheduled_at,
            'draw_date' => $request->draw_date,
            'win_type' => $request->win_type,
            'status' => $request->status ?? 'active',
        ];
    }

    /**
     * Process video for creation
     */
    private function processVideo(Request $request, array &$data): void
    {
        if (!$request->input('video_enabled')) {
            $data['video_url'] = null;
            $data['video_file'] = null;
            return;
        }

        $type = $request->video_type;

        if ($type === 'upload' && $request->hasFile('video_file')) {
            $data['video_file'] = $this->uploadFile($request->file('video_file'), self::VIDEO_DIR);
            $data['video_url'] = null;
        } elseif ($type === 'direct') {
            $data['video_url'] = $request->video_url_direct;
            $data['video_file'] = null;
        } elseif ($type === 'youtube') {
            $data['video_url'] = $this->extractYoutubeId($request->video_url_youtube);
            $data['video_file'] = null;
        }
    }

    /**
     * Process video for update
     */
    private function processVideoUpdate(Request $request, Lottery $lottery, array &$data, ?string $oldVideo): void
    {
        if (!$request->input('video_enabled')) {
            $data['video_url'] = null;
            $data['video_file'] = null;
            $this->deleteFile($oldVideo, self::VIDEO_DIR);
            return;
        }

        $type = $request->video_type;

        if ($type === 'upload') {
            if ($request->hasFile('video_file')) {
                $data['video_file'] = $this->uploadFile($request->file('video_file'), self::VIDEO_DIR);
                $data['video_url'] = null;
                $this->deleteFile($oldVideo, self::VIDEO_DIR);
            } else {
                $data['video_file'] = $lottery->video_file;
                $data['video_url'] = null;
            }
        } elseif ($type === 'direct') {
            $data['video_url'] = $request->video_url_direct;
            $data['video_file'] = null;
            if ($oldVideo && $lottery->video_type === 'upload') {
                $this->deleteFile($oldVideo, self::VIDEO_DIR);
            }
        } elseif ($type === 'youtube') {
            $data['video_url'] = $this->extractYoutubeId($request->video_url_youtube);
            $data['video_file'] = null;
            if ($oldVideo && $lottery->video_type === 'upload') {
                $this->deleteFile($oldVideo, self::VIDEO_DIR);
            }
        }
    }

    /**
     * Extract YouTube ID
     */
    private function extractYoutubeId(string $input): string
    {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $input, $m)) {
            return $m[1];
        }

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $input)) {
            return $input;
        }

        return $input;
    }

    /**
     * Upload file
     */
    private function uploadFile($file, string $dir): string
    {
        $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = public_path($dir);

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $file->move($path, $name);

        return $name;
    }

    /**
     * Delete file
     */
    private function deleteFile(?string $file, string $dir): bool
    {
        if (!$file) return false;

        $path = public_path($dir . '/' . $file);

        return File::exists($path) ? File::delete($path) : false;
    }

    /**
     * Cleanup failed uploads
     */
    private function cleanup(array $data): void
    {
        if (!empty($data['photo'])) {
            $this->deleteFile($data['photo'], self::PHOTO_DIR);
        }

        if (!empty($data['video_file'])) {
            $this->deleteFile($data['video_file'], self::VIDEO_DIR);
        }
    }

    /**
     * Filter array
     */
    private function filterArray(array $arr): array
    {
        return array_values(array_filter(array_map('trim', $arr), fn($v) => !empty($v)));
    }

    /**
     * Filter prices
     */
    private function filterPrices(array $arr): array
    {
        return array_values(array_map(fn($p) => max(0, (float)($p ?? 0)), $arr));
    }
}
