<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $table = 'profits'; // ডাটাবেস টেবিলের নাম
    protected $fillable = ['user_id', 'from_user_id', 'deposit_id', 'amount', 'level', 'note'];

    protected $casts = [
        'user_id' => 'integer',
        'from_user_id' => 'integer',
        'deposit_id' => 'integer',
        'amount' => 'decimal:2',
        'level' => 'integer',
    ];
   public function fromUser() {
        return $this->belongsTo(User::class, 'from_user_id');
    }

}
