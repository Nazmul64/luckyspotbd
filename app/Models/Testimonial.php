<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'message',
        'photo',
        'new_photo',
        'title',
        'description',
    ];
  protected $casts = [
        'name'        => 'array',
        'designation' => 'array',
        'message'     => 'array',
        'title'       => 'array',
        'description' => 'array',
    ];
}
