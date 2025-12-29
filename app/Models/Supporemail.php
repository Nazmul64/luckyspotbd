<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supporemail extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'messages',
    ];
}
