<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     protected $fillable = [
        'icon',
        'title',
        'email_phone',
        'map_code',
    ];
}
