<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Whychooseusticket extends Model
{
    protected $fillable = [
        'main_title',
        'main_description',
        'title',
        'description',
        'icon',
    ];
}
