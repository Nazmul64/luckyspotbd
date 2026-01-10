<?php
// app/Models/Lottery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Lottery extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'photo',
        'first_prize',
        'second_prize',
        'third_prize',
        'multiple_title',
        'multiple_price',
        'video_url',
        'video_enabled',
        'video_scheduled_at',
        'status',
        'draw_date',
        'win_type',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'price' => 'decimal:2',
        'first_prize' => 'decimal:2',
        'second_prize' => 'decimal:2',
        'third_prize' => 'decimal:2',
        'multiple_title' => 'array',
        'multiple_price' => 'array',
        'video_enabled' => 'boolean',
        'draw_date' => 'datetime',
        'video_scheduled_at' => 'datetime',
    ];

    /**
     * ✅ Get translated name based on current locale
     * This is the MAIN method to use in frontend
     */
    public function getTranslatedName()
    {
        $locale = app()->getLocale();

        // Since 'name' is cast as 'array', it will automatically be an array
        if (is_array($this->name)) {
            return $this->name[$locale] ?? $this->name['en'] ?? '';
        }

        // Fallback for old data (if somehow still stored as string)
        if (is_string($this->name)) {
            try {
                $decoded = json_decode($this->name, true);
                if (is_array($decoded)) {
                    return $decoded[$locale] ?? $decoded['en'] ?? $this->name;
                }
            } catch (\Exception $e) {
                return $this->name;
            }
        }

        return '';
    }

    /**
     * ✅ Get translated description based on current locale
     * This is the MAIN method to use in frontend
     */
    public function getTranslatedDescription()
    {
        $locale = app()->getLocale();

        // Since 'description' is cast as 'array', it will automatically be an array
        if (is_array($this->description)) {
            return $this->description[$locale] ?? $this->description['en'] ?? '';
        }

        // Fallback for old data (if somehow still stored as string)
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
     * ✅ Accessor for name in English (for admin panel)
     */
    public function getNameEnAttribute()
    {
        // Get the raw name (which is cast to array)
        $name = $this->name;

        if (is_array($name)) {
            return $name['en'] ?? '';
        }

        return '';
    }

    /**
     * ✅ Accessor for name in Bangla (for admin panel)
     */
    public function getNameBnAttribute()
    {
        // Get the raw name (which is cast to array)
        $name = $this->name;

        if (is_array($name)) {
            return $name['bn'] ?? '';
        }

        return '';
    }

    /**
     * ✅ Accessor for description in English (for admin panel)
     */
    public function getDescriptionEnAttribute()
    {
        // Get the raw description (which is cast to array)
        $description = $this->description;

        if (is_array($description)) {
            return $description['en'] ?? '';
        }

        return '';
    }

    /**
     * ✅ Accessor for description in Bangla (for admin panel)
     */
    public function getDescriptionBnAttribute()
    {
        // Get the raw description (which is cast to array)
        $description = $this->description;

        if (is_array($description)) {
            return $description['bn'] ?? '';
        }

        return '';
    }

    // ... rest of your existing methods ...

    public function shouldShowVideo(): bool
    {
        if (!$this->video_enabled || !$this->video_url || !$this->video_scheduled_at) {
            return false;
        }

        $now = Carbon::now();
        $videoStart = Carbon::parse($this->video_scheduled_at);

        Log::info("Video Check - Lottery ID: {$this->id}", [
            'current_time' => $now->format('Y-m-d H:i:s'),
            'video_scheduled' => $videoStart->format('Y-m-d H:i:s'),
            'should_show' => $now->gte($videoStart),
            'time_diff_seconds' => $now->diffInSeconds($videoStart, false),
        ]);

        return $now->gte($videoStart);
    }

    public function getVideoEmbedUrl(): ?string
    {
        if (!$this->video_url) {
            return null;
        }

        $videoUrl = trim($this->video_url);

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=0&rel=0&modestbranding=1&controls=1";
        }

        return $videoUrl;
    }

    public function getDrawTimestamp(): int
    {
        if (!$this->draw_date) {
            return 0;
        }
        return Carbon::parse($this->draw_date)->timestamp * 1000;
    }

    public function getVideoScheduledTimestamp(): int
    {
        if (!$this->video_scheduled_at) {
            return 0;
        }
        return Carbon::parse($this->video_scheduled_at)->timestamp * 1000;
    }

    public static function getCurrentServerTimestamp(): int
    {
        return Carbon::now()->timestamp * 1000;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isDrawCompleted(): bool
    {
        return $this->draw_date && Carbon::now()->gt(Carbon::parse($this->draw_date));
    }

    public function getFormattedDrawDate(): ?string
    {
        return $this->draw_date
            ? Carbon::parse($this->draw_date)->format('d M, Y h:i A')
            : null;
    }

    public function getFormattedVideoScheduledTime(): ?string
    {
        return $this->video_scheduled_at
            ? Carbon::parse($this->video_scheduled_at)->format('d M, Y h:i A')
            : null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('draw_date', '>', Carbon::now());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')
                     ->orWhere('draw_date', '<=', Carbon::now());
    }

    public function userPackageBuys()
    {
        return $this->hasMany(Userpackagebuy::class, 'package_id');
    }

    public function lotteryResults()
    {
        return $this->hasMany(LotteryResult::class, 'user_package_buy_id', 'id');
    }

    public function buys()
    {
        return $this->hasMany(Userpackagebuy::class, 'package_id');
    }

    public function results()
    {
        return $this->hasMany(LotteryResult::class);
    }
}
