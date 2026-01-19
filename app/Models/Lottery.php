<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Lottery extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lotteries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'photo',
        'first_prize',
        'second_prize',
        'third_prize',
        'multiple_title',
        'multiple_price',
        'video_type',
        'video_url',
        'video_file',
        'video_enabled',
        'video_scheduled_at',
        'draw_date',
        'win_type',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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
        'video_scheduled_at' => 'datetime',
        'draw_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'video_scheduled_at',
        'draw_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'price' => 0,
        'first_prize' => 0,
        'second_prize' => 0,
        'third_prize' => 0,
        'video_enabled' => false,
        'video_type' => 'direct',
        'status' => 'active',
    ];

    // ==========================================
    // MODEL BOOT
    // ==========================================

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Ensure JSON fields have proper defaults when creating
        static::creating(function ($lottery) {
            if (empty($lottery->name)) {
                $lottery->name = ['en' => '', 'bn' => ''];
            }
            if (empty($lottery->description)) {
                $lottery->description = ['en' => '', 'bn' => ''];
            }
            if (empty($lottery->multiple_title)) {
                $lottery->multiple_title = [];
            }
            if (empty($lottery->multiple_price)) {
                $lottery->multiple_price = [];
            }
        });
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get all user package buys for this lottery
     */
    public function userPackageBuys()
    {
        return $this->hasMany(Userpackagebuy::class, 'package_id');
    }

    /**
     * Get all buys for this lottery (alias)
     */
    public function buys()
    {
        return $this->hasMany(Userpackagebuy::class, 'package_id');
    }

    /**
     * Get all lottery results
     */
    public function lotteryResults()
    {
        return $this->hasMany(LotteryResult::class, 'user_package_buy_id', 'id');
    }

    /**
     * Get all results (alias)
     */
    public function results()
    {
        return $this->hasMany(LotteryResult::class);
    }

    // ==========================================
    // QUERY SCOPES
    // ==========================================

    /**
     * Scope: Only active lotteries
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Only inactive lotteries
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope: Only completed lotteries
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Upcoming draws (future draws)
     */
    public function scopeUpcoming($query)
    {
        return $query->where('draw_date', '>', now())
                     ->where('status', 'active')
                     ->orderBy('draw_date', 'asc');
    }

    /**
     * Scope: Past draws
     */
    public function scopePast($query)
    {
        return $query->where('draw_date', '<=', now())
                     ->orderBy('draw_date', 'desc');
    }

    /**
     * Scope: Lotteries with video enabled
     */
    public function scopeWithVideo($query)
    {
        return $query->where('video_enabled', true);
    }

    // ==========================================
    // MULTILINGUAL ACCESSORS (for Admin Panel)
    // ==========================================

    /**
     * Get English name (for admin forms)
     */
    public function getNameEnAttribute()
    {
        if (is_array($this->name)) {
            return $this->name['en'] ?? '';
        }
        return '';
    }

    /**
     * Get Bengali name (for admin forms)
     */
    public function getNameBnAttribute()
    {
        if (is_array($this->name)) {
            return $this->name['bn'] ?? '';
        }
        return '';
    }

    /**
     * Get English description (for admin forms)
     */
    public function getDescriptionEnAttribute()
    {
        if (is_array($this->description)) {
            return $this->description['en'] ?? '';
        }
        return '';
    }

    /**
     * Get Bengali description (for admin forms)
     */
    public function getDescriptionBnAttribute()
    {
        if (is_array($this->description)) {
            return $this->description['bn'] ?? '';
        }
        return '';
    }

    // ==========================================
    // TRANSLATION METHODS (for Frontend)
    // ==========================================

    /**
     * Get translated name based on current app locale
     * USE THIS IN FRONTEND VIEWS
     */
    public function getTranslatedName()
    {
        $locale = app()->getLocale();

        if (is_array($this->name)) {
            return $this->name[$locale] ?? $this->name['en'] ?? '';
        }

        // Fallback for old string data
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
     * Get translated description based on current app locale
     * USE THIS IN FRONTEND VIEWS
     */
    public function getTranslatedDescription()
    {
        $locale = app()->getLocale();

        if (is_array($this->description)) {
            return $this->description[$locale] ?? $this->description['en'] ?? '';
        }

        // Fallback for old string data
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
     * Get localized name attribute (alternative method)
     */
    public function getLocalizedNameAttribute()
    {
        return $this->getTranslatedName();
    }

    /**
     * Get localized description attribute (alternative method)
     */
    public function getLocalizedDescriptionAttribute()
    {
        return $this->getTranslatedDescription();
    }

    // ==========================================
    // STATUS & STATE CHECKERS
    // ==========================================

    /**
     * Check if lottery is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if lottery is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if draw date has passed
     */
    public function isDrawPassed(): bool
    {
        return $this->draw_date && $this->draw_date->isPast();
    }

    /**
     * Check if draw is completed (alias)
     */
    public function isDrawCompleted(): bool
    {
        return $this->draw_date && Carbon::now()->gt(Carbon::parse($this->draw_date));
    }

    /**
     * Check if draw is today
     */
    public function isDrawToday(): bool
    {
        return $this->draw_date && $this->draw_date->isToday();
    }

    // ==========================================
    // DATE & TIME METHODS
    // ==========================================

    /**
     * Get days remaining until draw
     */
    public function getDaysUntilDraw(): int
    {
        if (!$this->draw_date) {
            return 0;
        }

        return max(0, now()->diffInDays($this->draw_date, false));
    }

    /**
     * Get formatted draw date
     */
    public function getFormattedDrawDate(?string $format = 'd M, Y h:i A'): ?string
    {
        return $this->draw_date ? $this->draw_date->format($format) : null;
    }

    /**
     * Get formatted video scheduled time
     */
    public function getFormattedVideoScheduledTime(?string $format = 'd M, Y h:i A'): ?string
    {
        return $this->video_scheduled_at
            ? Carbon::parse($this->video_scheduled_at)->format($format)
            : null;
    }

    /**
     * Get draw timestamp in milliseconds (for JavaScript)
     */
    public function getDrawTimestamp(): int
    {
        if (!$this->draw_date) {
            return 0;
        }
        return Carbon::parse($this->draw_date)->timestamp * 1000;
    }

    /**
     * Get video scheduled timestamp in milliseconds (for JavaScript)
     */
    public function getVideoScheduledTimestamp(): int
    {
        if (!$this->video_scheduled_at) {
            return 0;
        }
        return Carbon::parse($this->video_scheduled_at)->timestamp * 1000;
    }

    /**
     * Get current server timestamp in milliseconds (for JavaScript sync)
     */
    public static function getCurrentServerTimestamp(): int
    {
        return Carbon::now()->timestamp * 1000;
    }

    // ==========================================
    // VIDEO METHODS
    // ==========================================

    /**
     * Check if video should be shown now (based on schedule)
     */
    public function shouldShowVideo(): bool
    {
        if (!$this->video_enabled || !$this->video_url || !$this->video_scheduled_at) {
            return false;
        }

        $now = Carbon::now();
        $videoStart = Carbon::parse($this->video_scheduled_at);

        // Optional: Log for debugging
        Log::info("Video Check - Lottery ID: {$this->id}", [
            'current_time' => $now->format('Y-m-d H:i:s'),
            'video_scheduled' => $videoStart->format('Y-m-d H:i:s'),
            'should_show' => $now->gte($videoStart),
            'time_diff_seconds' => $now->diffInSeconds($videoStart, false),
        ]);

        return $now->gte($videoStart);
    }

    /**
     * Get video embed URL (for iframe)
     */
    public function getVideoEmbedUrl(): ?string
    {
        if (!$this->video_url) {
            return null;
        }

        $videoUrl = trim($this->video_url);

        // Extract YouTube video ID and return embed URL
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=0&rel=0&modestbranding=1&controls=1";
        }

        // Return direct URL as-is
        return $videoUrl;
    }

    /**
     * Get video source based on video type
     */
    public function getVideoSourceAttribute(): ?string
    {
        if (!$this->video_enabled) {
            return null;
        }

        switch ($this->video_type) {
            case 'upload':
                return $this->video_file ? asset('uploads/lottery/videos/' . $this->video_file) : null;
            case 'youtube':
                return $this->video_url ? 'https://www.youtube.com/watch?v=' . $this->video_url : null;
            case 'direct':
                return $this->video_url;
            default:
                return null;
        }
    }

    /**
     * Get YouTube embed URL attribute
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if ($this->video_type === 'youtube' && $this->video_url) {
            return 'https://www.youtube.com/embed/' . $this->video_url;
        }
        return null;
    }

    // ==========================================
    // PHOTO & MEDIA METHODS
    // ==========================================

    /**
     * Get photo URL
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('uploads/lottery/' . $this->photo) : null;
    }

    // ==========================================
    // PACKAGE METHODS
    // ==========================================

    /**
     * Get total number of packages
     */
    public function getPackageCountAttribute(): int
    {
        return count($this->multiple_title ?? []);
    }

    // ==========================================
    // PRICE & PRIZE METHODS
    // ==========================================

    /**
     * Format price with currency
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0) . ' টাকা';
    }

    /**
     * Get total prize money (sum of all prizes)
     */
    public function getTotalPrizeMoneyAttribute(): float
    {
        return $this->first_prize + $this->second_prize + $this->third_prize;
    }

    /**
     * Get formatted first prize
     */
    public function getFormattedFirstPrizeAttribute(): string
    {
        return number_format($this->first_prize, 0) . ' টাকা';
    }

    /**
     * Get formatted second prize
     */
    public function getFormattedSecondPrizeAttribute(): string
    {
        return number_format($this->second_prize, 0) . ' টাকা';
    }

    /**
     * Get formatted third prize
     */
    public function getFormattedThirdPrizeAttribute(): string
    {
        return number_format($this->third_prize, 0) . ' টাকা';
    }

    /**
     * Get formatted total prize money
     */
    public function getFormattedTotalPrizeAttribute(): string
    {
        return number_format($this->total_prize_money, 0) . ' টাকা';
    }
}
