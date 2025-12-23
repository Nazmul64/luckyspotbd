<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LotteryResult extends Model
{
    // =========================
    // MASS ASSIGNABLE FIELDS
    // =========================
    protected $fillable = [
        'user_package_buy_id', // টিকিট আইডি
        'user_id',             // ইউজার আইডি
        'win_status',          // won / lost
        'win_amount',          // টিকিটের মূল্য বা জেতার মান
        'gift_amount',         // প্রাইজ বা multiple_price যোগ
        'position',            // first / second / third
        'draw_date',           // ড্র এর তারিখ
        'status',              // active / inactive

    ];

    // =========================
    // CASTS
    // =========================
    protected $casts = [
        'draw_date' => 'datetime',

    ];

    // =========================
    // RELATIONS
    // =========================

    /**
     * LotteryResult থেকে Ticket/Ticket info
     */
    public function userPackageBuy(): BelongsTo
    {
        return $this->belongsTo(Userpackagebuy::class, 'user_package_buy_id');
    }

    /**
     * LotteryResult থেকে User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // =========================
    // SCOPES / CUSTOM METHODS
    // =========================

    /**
     * Scope to get pending results (no status yet)
     */
    public function scopePending($query)
    {
        return $query->where('win_status', null);
    }
}
