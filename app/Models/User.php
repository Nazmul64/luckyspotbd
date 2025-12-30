<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'number',
        'country',
        'profile_photo',
        'username',
        'first_name',
        'last_name',
        'referred_by',
        'ref_id',
        'ref_code',
        'balance',
        'refer_income',
        'address',
        'status',
        'zip_code',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function referrer() {
    return $this->belongsTo(User::class, 'referred_by');
}
public function referrals() {
    return $this->hasMany(User::class, 'referred_by');
}
public function deposits() {
    return $this->hasMany(Deposite::class, 'user_id');
}
public function profits() {
    return $this->hasMany(Profit::class, 'user_id');
}


public function withdrawals()
    {
        return $this->hasMany(User_widthdraw::class);
    }

 public function lotteryResults()
    {
        return $this->hasMany(LotteryResult::class, 'user_id', 'id');
    }
    public function userWidthdraws()
{
    return $this->hasMany(User_widthdraw::class);
}
    public function userdeposite()
{
    return $this->hasMany(Deposite::class);
}
  public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation to LotteryResult (optional)
    public function results()
    {
        return $this->hasMany(LotteryResult::class, 'user_package_buy_id');
    }

public function userPackageBuys()
{
    return $this->hasMany(Userpackagebuy::class, 'user_id');
}

public function kyc()
{
    return $this->hasOne(Kyc::class);
}
public function kycagent(){
    return $this->belongsTo(User::class, 'user_id');
}




}
