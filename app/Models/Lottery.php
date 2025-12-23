<?php

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
        'price' => 'decimal:2',
        'first_prize' => 'decimal:2',
        'second_prize' => 'decimal:2',
        'third_prize' => 'decimal:2',
        'multiple_title' => 'array',
        'multiple_price' => 'array',
        'video_enabled' => 'boolean',
        // ⚠️ IMPORTANT: datetime cast removed করা হয়েছে
        // কারণ আমরা manually handle করব timezone conversion ছাড়া
    ];

    /**
     * ⭐ CRITICAL: Get video_scheduled_at WITHOUT any timezone conversion
     * Database এ যা আছে ঠিক তা-ই return করবে
     */
    public function getVideoScheduledAtAttribute($value)
    {
        if (!$value) {
            return null;
        }
        // Database value কে directly Carbon এ convert করছি
        // কোন timezone conversion করছি না
        return Carbon::parse($value);
    }

    /**
     * ⭐ CRITICAL: Get draw_date WITHOUT any timezone conversion
     */
    public function getDrawDateAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return Carbon::parse($value);
    }

    /**
     * Check if video should be shown now
     * Server time দিয়ে check করবে
     */
    public function shouldShowVideo(): bool
    {
        if (!$this->video_enabled || !$this->video_url || !$this->video_scheduled_at) {
            return false;
        }

        $now = Carbon::now();
        $videoStart = Carbon::parse($this->video_scheduled_at);

        // Debug log for troubleshooting
        Log::info("Video Check - Lottery ID: {$this->id}", [
            'current_time' => $now->format('Y-m-d H:i:s'),
            'video_scheduled' => $videoStart->format('Y-m-d H:i:s'),
            'should_show' => $now->gte($videoStart),
            'time_diff_seconds' => $now->diffInSeconds($videoStart, false),
        ]);

        return $now->gte($videoStart);
    }

    /**
     * Get video embed URL for YouTube or direct video
     */
    public function getVideoEmbedUrl(): ?string
    {
        if (!$this->video_url) {
            return null;
        }

        $videoUrl = trim($this->video_url);

        // YouTube URL থেকে embed URL তৈরি করা
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=0&rel=0&modestbranding=1&controls=1";
        }

        // Direct video URL return করা
        return $videoUrl;
    }

    /**
     * Get draw timestamp in milliseconds for JavaScript
     * Frontend এ countdown এর জন্য দরকার
     */
    public function getDrawTimestamp(): int
    {
        if (!$this->draw_date) {
            return 0;
        }
        return Carbon::parse($this->draw_date)->timestamp * 1000;
    }

    /**
     * Get video scheduled timestamp in milliseconds
     * Frontend এ video countdown এর জন্য দরকার
     */
    public function getVideoScheduledTimestamp(): int
    {
        if (!$this->video_scheduled_at) {
            return 0;
        }
        return Carbon::parse($this->video_scheduled_at)->timestamp * 1000;
    }

    /**
     * Get current server timestamp in milliseconds
     * Frontend এ server time sync করার জন্য
     */
    public static function getCurrentServerTimestamp(): int
    {
        return Carbon::now()->timestamp * 1000;
    }

    /**
     * Check if lottery is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if draw date has passed
     */
    public function isDrawCompleted(): bool
    {
        return $this->draw_date && Carbon::now()->gt(Carbon::parse($this->draw_date));
    }

    /**
     * Get formatted draw date for display
     */
    public function getFormattedDrawDate(): ?string
    {
        return $this->draw_date
            ? Carbon::parse($this->draw_date)->format('d M, Y h:i A')
            : null;
    }

    /**
     * Get formatted video scheduled time for display
     */
    public function getFormattedVideoScheduledTime(): ?string
    {
        return $this->video_scheduled_at
            ? Carbon::parse($this->video_scheduled_at)->format('d M, Y h:i A')
            : null;
    }

    /**
     * Scope: Active lotteries only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Upcoming lotteries (draw date in future)
     */
    public function scopeUpcoming($query)
    {
        return $query->where('draw_date', '>', Carbon::now());
    }

    /**
     * Scope: Completed lotteries
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')
                     ->orWhere('draw_date', '<=', Carbon::now());
    }

    /**
     * Relationships
     */
    public function userPackageBuys()
    {
        return $this->hasMany(Userpackagebuy::class, 'package_id');
    }


    protected $dates = ['draw_date'];


public function lotteryResults()
{
    return $this->hasMany(LotteryResult::class, 'user_package_buy_id', 'id');
}

// Userpackagebuy.php
public function user()
{
    return $this->belongsTo(User::class);
}
public function lottery()
{
    return $this->belongsTo(Lottery::class, 'package_id');
}
public function result()
{
    return $this->hasOne(LotteryResult::class, 'user_package_buy_id');
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
