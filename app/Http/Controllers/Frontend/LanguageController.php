<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    /**
     * Change language
     */
    public function changeLanguage(Request $request)
    {
        try {
            // Validate করুন
            $lang = $request->input('lang');

            if (!in_array($lang, ['en', 'bn'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid language'
                ], 400);
            }

            // Session এ save করুন (এটি খুবই গুরুত্বপূর্ণ)
            Session::put('locale', $lang);
            Session::save(); // ✅ Force save করুন

            // তৎক্ষণাৎ locale set করুন
            App::setLocale($lang);

            // Log করুন debugging এর জন্য
            Log::info('Language changed', [
                'new_locale' => $lang,
                'session_locale' => Session::get('locale'),
                'app_locale' => App::getLocale()
            ]);

            return response()->json([
                'status' => true,
                'locale' => $lang,
                'message' => $lang === 'bn' ? 'ভাষা পরিবর্তন সফল হয়েছে' : 'Language changed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Language change error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Server error'
            ], 500);
        }
    }
}
