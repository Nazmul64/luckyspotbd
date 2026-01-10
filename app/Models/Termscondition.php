<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termscondition extends Model
{
    protected $fillable = ['title', 'description'];

    // Automatically cast JSON fields to array
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    // Helper functions for locale-specific data
    public function getTitleByLocale($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $this->title[$locale] ?? '';
    }

    public function getDescriptionByLocale($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $this->description[$locale] ?? '';
    }
}
