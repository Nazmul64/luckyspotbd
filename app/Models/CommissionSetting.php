<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionSetting extends Model
{
    protected $fillable = [
        'refer_commission',
        'generation_level_1',
        'generation_level_2',
        'generation_level_3',
        'generation_level_4',
        'generation_level_5',
        'status',
    ];
}
