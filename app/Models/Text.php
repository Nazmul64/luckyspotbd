<?php
// app/Models/Text.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'language_code',
        'value'
    ];

    /**
     * Get translations by language
     */
    public static function getByLanguage($languageCode)
    {
        return self::where('language_code', $languageCode)->get();
    }

    /**
     * Get translation by key
     */
    public static function getTranslation($key, $languageCode)
    {
        return self::where('key', $key)
                   ->where('language_code', $languageCode)
                   ->first();
    }
}
