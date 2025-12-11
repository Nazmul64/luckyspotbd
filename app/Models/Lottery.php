<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'photo',
        'status',
        'draw_date',
        'first_prize',
        'second_prize',
        'third_prize',
        'win_type',
    ];

    protected $casts = [
        'draw_date' => 'datetime',
    ];
    // Userpackagebuy.php
public function userPackageBuys()
{
    return $this->hasMany(Userpackagebuy::class, 'package_id');
}
public function user()
{
    return $this->belongsTo(User::class);
}
public function lottery()
{
    return $this->belongsTo(Lottery::class, 'package_id');
}
public function buys()
{
    return $this->hasMany(Userpackagebuy::class, 'package_id');
}
}
