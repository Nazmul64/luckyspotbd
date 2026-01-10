<?php
// app/Http/Controllers/Frontend/LanguageController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class LanguageController extends Controller
{
    /**
     * Change language
     */
    public function changeLanguage(Request $request)
    {
        try {
            $lang = $request->input('lang');

            // Validate করুন
            if (!in_array($lang, ['en', 'bn'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid language selected'
                ], 400);
            }

            // পুরাতন locale নিন
            $oldLocale = Session::get('locale', 'en');

            // Session এ নতুন locale save করুন
            Session::put('locale', $lang);
            Session::save();

            // তৎক্ষণাৎ locale set করুন
            App::setLocale($lang);

            // Translation cache clear করুন যাতে নতুন language load হয়
            Cache::flush(); // অথবা শুধু translation cache clear করুন

            // Log করুন
            Log::info('Language changed successfully', [
                'old_locale' => $oldLocale,
                'new_locale' => $lang,
                'session_locale' => Session::get('locale'),
                'app_locale' => App::getLocale(),
                'ip' => $request->ip()
            ]);

            return response()->json([
                'status' => true,
                'locale' => $lang,
                'old_locale' => $oldLocale,
                'message' => $lang === 'bn'
                    ? 'ভাষা সফলভাবে পরিবর্তন হয়েছে!'
                    : 'Language changed successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Language change error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to change language. Please try again.'
            ], 500);
        }
    }
}
