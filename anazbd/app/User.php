<?php

namespace App;

use App\Models\BillingAddress;
use App\Models\City;
use App\Models\Comment;
use App\Models\DeliveryAddress;
use App\Models\Division;
use App\Models\Order;
use App\Models\PostCode;
use App\Models\Wishlist;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, AutoTimeStamp, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'device_token', 'mobile', 'password', 'otp', 'otp_generated_at', 'subscription', 'division_id', 'city_id', 'post_code_id', 'address_line_1', 'address_line_2','provider', 'provider_id','status','platform_origin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','otp','otp_generated_at','login_token','login_otp','login_token_generated_at  '
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function cash_return()
    {
        return $this->hasOne(CashReturn::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function area()
    {
        return $this->belongsTo(PostCode::class, 'post_code_id');
    }

    public function billing_address()
    {
        return $this->hasMany(BillingAddress::class)->latest()->limit(1);
    }

    public function user_point()
    {
        return $this->hasOne(UserPoint::class);
    }
    
    public function point_transactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function delivery_address()
    {
        return $this->hasMany(DeliveryAddress::class)->latest()->limit(1);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
}
