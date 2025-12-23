<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Change the application language (English or Bangla)
     * Stores the language in session
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeLanguage(Request $request)
    {
        $lang = $request->input('lang');

        // Validate language
        if (in_array($lang, ['en', 'bn'])) {
            Session::put('locale', $lang);
            App::setLocale($lang);
        }

        return response()->json(['status' => true]);
    }

    /**
     * Get all texts for the current language
     * Reads from 'texts' table based on keys
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getText(Request $request)
    {
        // Get current locale from session, fallback to app default
        $lang = Session::get('locale', config('app.locale'));

        // Define keys to fetch
        $keys = [
            'welcome',
            'home',
            'about',
            'ticket',
            'faq',
            'pages',
            'user_dashboard',
            'ticket_details',
            'privacy_policy',
            'terms_conditions',
            'contact',
            'login',
            'languages'
        ];

        $texts = [];

        foreach ($keys as $key) {
            $text = Text::where('key', $key)
                        ->where('language_code', $lang)
                        ->first();

            $texts[$key] = $text ? $text->value : '';
        }

        return response()->json($texts);
    }
}
