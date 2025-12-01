<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawCommission extends Model
{
    use HasFactory;

    protected $table = 'withdraw_commissions';

    protected $fillable = [
        'withdraw_commission',
        'minimum_withdraw',
        'maximum_withdraw',
        'minimum_deposite',
        'maximum_deposite',
        'status',

    ];
}
