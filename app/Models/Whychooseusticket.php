<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Whychooseusticket extends Model
{
    protected $fillable = [
        'main_title',
        'main_description',
        'title',
        'description',
        'icon',
    ];

    protected $casts = [
        'main_title' => 'array',
        'main_description' => 'array',
        'title' => 'array',
        'description' => 'array',
    ];

    /**
     * ✅ Get translated main title based on current locale
     */
    public function getTranslatedMainTitle()
    {
        $locale = app()->getLocale();

        if (is_array($this->main_title)) {
            return $this->main_title[$locale] ?? $this->main_title['en'] ?? '';
        }

        // Fallback for old data
        if (is_string($this->main_title)) {
            try {
                $decoded = json_decode($this->main_title, true);
                if (is_array($decoded)) {
                    return $decoded[$locale] ?? $decoded['en'] ?? $this->main_title;
                }
            } catch (\Exception $e) {
                return $this->main_title;
            }
        }

        return '';
    }

    /**
     * ✅ Get translated main description based on current locale
     */
    public function getTranslatedMainDescription()
    {
        $locale = app()->getLocale();

        if (is_array($this->main_description)) {
            return $this->main_description[$locale] ?? $this->main_description['en'] ?? '';
        }

        // Fallback for old data
        if (is_string($this->main_description)) {
            try {
                $decoded = json_decode($this->main_description, true);
                if (is_array($decoded)) {
                    return $decoded[$locale] ?? $decoded['en'] ?? $this->main_description;
                }
            } catch (\Exception $e) {
                return $this->main_description;
            }
        }

        return '';
    }

    /**
     * ✅ Get translated title based on current locale
     */
    public function getTranslatedTitle()
    {
        $locale = app()->getLocale();

        if (is_array($this->title)) {
            return $this->title[$locale] ?? $this->title['en'] ?? '';
        }

        // Fallback for old data
        if (is_string($this->title)) {
            try {
                $decoded = json_decode($this->title, true);
                if (is_array($decoded)) {
                    return $decoded[$locale] ?? $decoded['en'] ?? $this->title;
                }
            } catch (\Exception $e) {
                return $this->title;
            }
        }

        return '';
    }

    /**
     * ✅ Get translated description based on current locale
     */
    public function getTranslatedDescription()
    {
        $locale = app()->getLocale();

        if (is_array($this->description)) {
            return $this->description[$locale] ?? $this->description['en'] ?? '';
        }

        // Fallback for old data
        if (is_string($this->description)) {
            try {
                $decoded = json_decode($this->description, true);
                if (is_array($decoded)) {
                    return $decoded[$locale] ?? $decoded['en'] ?? $this->description;
                }
            } catch (\Exception $e) {
                return $this->description;
            }
        }

        return '';
    }

    /**
     * ✅ Accessors for admin panel - Main Title
     */
    public function getMainTitleEnAttribute()
    {
        $mainTitle = $this->main_title;

        if (is_array($mainTitle)) {
            return $mainTitle['en'] ?? '';
        }

        return '';
    }

    public function getMainTitleBnAttribute()
    {
        $mainTitle = $this->main_title;

        if (is_array($mainTitle)) {
            return $mainTitle['bn'] ?? '';
        }

        return '';
    }

    /**
     * ✅ Accessors for admin panel - Main Description
     */
    public function getMainDescriptionEnAttribute()
    {
        $mainDescription = $this->main_description;

        if (is_array($mainDescription)) {
            return $mainDescription['en'] ?? '';
        }

        return '';
    }

    public function getMainDescriptionBnAttribute()
    {
        $mainDescription = $this->main_description;

        if (is_array($mainDescription)) {
            return $mainDescription['bn'] ?? '';
        }

        return '';
    }

    /**
     * ✅ Accessors for admin panel - Title
     */
    public function getTitleEnAttribute()
    {
        $title = $this->title;

        if (is_array($title)) {
            return $title['en'] ?? '';
        }

        return '';
    }

    public function getTitleBnAttribute()
    {
        $title = $this->title;

        if (is_array($title)) {
            return $title['bn'] ?? '';
        }

        return '';
    }

    /**
     * ✅ Accessors for admin panel - Description
     */
    public function getDescriptionEnAttribute()
    {
        $description = $this->description;

        if (is_array($description)) {
            return $description['en'] ?? '';
        }

        return '';
    }

    public function getDescriptionBnAttribute()
    {
        $description = $this->description;

        if (is_array($description)) {
            return $description['bn'] ?? '';
        }

        return '';
    }
}
