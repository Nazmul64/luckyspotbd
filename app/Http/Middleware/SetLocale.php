<?php
// app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Session থেকে locale নিন, না থাকলে default 'en'
        $locale = Session::get('locale', config('app.locale', 'en'));

        // Validate করুন যে locale supported কিনা
        $supportedLocales = ['en', 'bn'];

        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
            Session::put('locale', $locale);
        }

        // Application locale set করুন
        App::setLocale($locale);

        // Debugging log (production এ বন্ধ করে দিবেন)
        Log::debug('Locale set in middleware', [
            'session_locale' => Session::get('locale'),
            'app_locale' => App::getLocale(),
            'url' => $request->url()
        ]);

        return $next($request);
    }
}
