<?php
// app/Helpers/TranslationHelper.php (অথবা আপনার helper file)

use App\Models\Text;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

if (!function_exists('trans_db')) {
    /**
     * Get translation from database
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    function trans_db($key, $default = '')
    {
        if (empty($key)) {
            return $default ?: $key;
        }

        // Current locale নিন
        $locale = App::getLocale();

        try {
            // Cache key তৈরি করুন
            $cacheKey = "trans_{$locale}_{$key}";

            // Cache থেকে চেষ্টা করুন (1 minute cache)
            $value = Cache::remember($cacheKey, 60, function () use ($key, $locale, $default) {

                // Database থেকে translation খুঁজুন
                $text = Text::where('key', $key)
                           ->where('language_code', $locale)
                           ->first();

                if ($text && !empty($text->value)) {
                    return $text->value;
                }

                // যদি না পাওয়া যায়, auto-create করুন
                try {
                    Text::updateOrCreate(
                        [
                            'key' => $key,
                            'language_code' => $locale
                        ],
                        [
                            'value' => $default ?: $key
                        ]
                    );
                } catch (\Exception $e) {
                    Log::warning('Failed to create translation', [
                        'key' => $key,
                        'locale' => $locale,
                        'error' => $e->getMessage()
                    ]);
                }

                return $default ?: $key;
            });

            return $value;

        } catch (\Exception $e) {
            Log::error('trans_db error', [
                'key' => $key,
                'locale' => $locale,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $default ?: $key;
        }
    }
}
