<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
   protected $fillable = [
        'photo',
        'favicon',
        'new_favicon',
        'new_photo',
        'phone',
        'email',
        'address',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'tilegram',
        'youtube',
        'footer_about',
        'footer_text',
    ];
}
