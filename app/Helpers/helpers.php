<?php

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
            return $default;
        }

        $locale = App::getLocale();

        try {
            // Cache key তৈরি করুন
            $cacheKey = "trans_db_{$locale}_{$key}";

            // Cache থেকে চেষ্টা করুন (5 minutes)
            $value = Cache::remember($cacheKey, 300, function () use ($key, $locale, $default) {
                $text = Text::where('key', $key)
                           ->where('language_code', $locale)
                           ->first();

                if ($text) {
                    return $text->value;
                }

                // ❗ Auto insert missing translation
                try {
                    Text::create([
                        'key' => $key,
                        'language_code' => $locale,
                        'value' => $default ?: $key,
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Failed to auto-create translation', [
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
                'error' => $e->getMessage()
            ]);

            return $default ?: $key;
        }
    }
}
