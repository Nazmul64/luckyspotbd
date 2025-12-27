<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Text extends Model
{
    protected $fillable = ['key', 'language_code', 'value'];

    /**
     * Get text by key for current locale
     */
    public static function get($key, $default = '')
    {
        $locale = App::getLocale();

        $text = self::where('key', $key)
                   ->where('language_code', $locale)
                   ->first();

        return $text ? $text->value : $default;
    }
}
