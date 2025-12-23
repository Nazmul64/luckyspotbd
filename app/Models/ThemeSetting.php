<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
   protected $fillable = [
        'primary_color',
        'secondary_color',
        'status'
    ];
}
