<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $table = 'profits'; // ডাটাবেস টেবিলের নাম
    protected $fillable = ['user_id', 'total_deposit', 'total_profit'];

    protected $casts = [
        'user_id' => 'integer',
        'total_deposit' => 'decimal:2',
        'total_profit' => 'decimal:2',
    ];
}
