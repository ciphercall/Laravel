<?php

namespace App;

use App\Models\Item;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\SellerProfile;
use App\Traits\AutoTimeStamp;
use App\Traits\Sluggable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable
{
    use Notifiable, AutoTimeStamp, Sluggable;

    protected $guard = 'seller';

    protected $fillable = [
        'name', 'email', 'password', 'shop_name', 'image','delivery_charge', 'mobile', 'otp', 'status', 'charge', 'is_commission_based_on_product', 'commission_type', 'commission'
    ];

    protected $hidden = [
        'password', 'remember_token', 'id',
    ];

    protected $append = [
        'delivery_charge'
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'seller_id');
    }

    public function hotSellers()
    {
        // return $this->hasMany()
        dd($this->order_items);
        $soldItems = collect($this->order_items)->groupBy('item_id');
        dd($soldItems);
    }

    public function random_items()
    {
        return $this->hasMany(Item::class)->select('id', 'feature_image', 'seller_id','slug')->inRandomOrder()->limit(18);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class,'seller_id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'seller_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    public function profile()
    {
        return $this->hasOne(SellerProfile::class, 'seller_id', 'id');
    }

    public function businessAddress()
    {
        return $this->hasOne(SellerBusinessAddress::class, 'seller_id', 'id');
    }

    public function returnAddress()
    {
        return $this->hasOne(SellerReturnAddress::class, 'seller_id', 'id');
    }

    /* Attributes */


    public function getSellerCommissionAttribute($price = null)
    {
        if($this->commission > 0){
            if($this->commission_type == 'percent'){
                return ($price * ($this->commission/100));
            }else{
                return $this->commission;
            }
        }
        return 0;
    }


}
