<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privacypolicy extends Model
{
    protected $fillable = ['title', 'description'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

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
