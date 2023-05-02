<?php

namespace App\Models;

use App\Seller;
use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use AutoTimeStamp, AuthScopes;

    protected $guarded = ['id'];

    protected $hidden = ['id', 'item_id', 'seller_id', 'flash_sale_id'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function sale()
    {
        return $this->belongsTo(FlashSale::class, 'flash_sale_id');
    }

    // scopes
    public function scopeWhereCurrentDateTime($q)
    {
        $q->where('start_time', '<=', date('Y-m-d H:i:s'))
            ->where('end_time', '>', date('Y-m-d H:i:s'));
    }

    public function scopeWhereDateTime($q, $dateTime)
    {
        $q->where('start_time', '<=', $dateTime)
            ->where('end_time', '>', $dateTime);
    }

    // attributes

    public function getStartTimeAttribute($v)
    {
        return Carbon::parse($v);
    }

    public function getEndTimeAttribute($v)
    {
        return Carbon::parse($v);
    }
}
