<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['title', 'description', 'photo', 'status'];

    /**
     * ✅ Cast JSON columns to array
     */
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Get translated title based on current locale
     */
    public function getTranslatedTitle()
    {
        $locale = app()->getLocale();

        // Handle both array and string formats (for backward compatibility)
        if (is_array($this->title)) {
            return $this->title[$locale] ?? $this->title['en'] ?? '';
        }

        return $this->title ?? '';
    }

    /**
     * Get translated description based on current locale
     */
    public function getTranslatedDescription()
    {
        $locale = app()->getLocale();

        // Handle both array and string formats (for backward compatibility)
        if (is_array($this->description)) {
            return $this->description[$locale] ?? $this->description['en'] ?? '';
        }

        return $this->description ?? '';
    }

    /**
     * Accessor for title in English (for admin panel)
     */
    public function getTitleEnAttribute()
    {
        return is_array($this->title) ? ($this->title['en'] ?? '') : $this->title;
    }

    /**
     * Accessor for title in Bangla (for admin panel)
     */
    public function getTitleBnAttribute()
    {
        return is_array($this->title) ? ($this->title['bn'] ?? '') : '';
    }

    /**
     * Accessor for description in English (for admin panel)
     */
    public function getDescriptionEnAttribute()
    {
        return is_array($this->description) ? ($this->description['en'] ?? '') : $this->description;
    }

    /**
     * Accessor for description in Bangla (for admin panel)
     */
    public function getDescriptionBnAttribute()
    {
        return is_array($this->description) ? ($this->description['bn'] ?? '') : '';
    }
}
