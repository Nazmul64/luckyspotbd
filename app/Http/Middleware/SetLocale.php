<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Session থেকে locale নিন, না থাকলে config থেকে default
        $locale = Session::get('locale', config('app.locale', 'en'));

        // Validate করুন শুধুমাত্র allowed languages
        if (in_array($locale, ['en', 'bn'])) {
            App::setLocale($locale);
        } else {
            // Invalid হলে default set করুন
            $locale = 'en';
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        return $next($request);
    }
}
