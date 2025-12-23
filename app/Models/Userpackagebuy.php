<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Userpackagebuy extends Model
{
    protected $table = 'userpackagebuys';

    protected $fillable = [
        'user_id',
        'package_id',
        'price',
        'status',
        'purchased_at',
        'ticket_number',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'price'        => 'decimal:2',
    ];

    /* ===================== BOOT ===================== */

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->ticket_number)) {
                do {
                    $ticket = 'L-' . now()->format('Ymd') . '-' . Str::upper(Str::random(8));
                } while (self::where('ticket_number', $ticket)->exists());

                $model->ticket_number = $ticket;
            }
        });
    }

    /* ===================== RELATIONSHIPS ===================== */

    // 🔹 User who bought the package
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 Lottery / Package
    public function package()
    {
        return $this->belongsTo(Lottery::class, 'package_id');
    }

    // 🔹 Lottery results
    public function results()
    {
        return $this->hasMany(LotteryResult::class, 'user_package_buy_id');
    }

    /* ===================== HELPERS ===================== */

    // Check if ticket has won
    public function hasWon(): bool
    {
        return $this->results()->where('win_status', 'won')->exists();
    }
}
