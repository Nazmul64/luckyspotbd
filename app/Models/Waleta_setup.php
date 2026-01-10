<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waleta_setup extends Model
{
   protected $casts = [
        'bankname'      => 'array',  // JSON for multiple languages
        'accountnumber' => 'array',  // JSON for multiple languages
        'status'        => 'string',
        'photo'         => 'string',
    ];
protected $fillable = [
    'status',
    'bankname',
    'accountnumber',
    'photo',
    'new_photo',
];
}
