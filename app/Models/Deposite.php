<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposite extends Model
{
    protected $fillable=[
     "user_id","amount","payment_method","transaction_id","screenshot","status","new_screenshot",
   ];
     public $timestamps = true; // ensure timestamps enabled

  protected $casts = [
    'user_id' => 'string',
    'amount' => 'string',
    'payment_method' => 'string',
    'transaction_id' => 'string',
    'screenshot'=> 'string',
    'status'=> 'string',
    'status'=> 'string',
];
  public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
