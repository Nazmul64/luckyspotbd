<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
     protected $fillable=[
        'support_link',
        'title',
        'status',
        'photo',
        'new_photo',
    ];
}
