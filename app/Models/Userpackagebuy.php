<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userpackagebuy extends Model
{

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
    ];
}
