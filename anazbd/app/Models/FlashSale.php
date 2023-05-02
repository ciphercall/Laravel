<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    public function sale_items()
    {
        return $this->hasMany(FlashSaleItem::class, 'flash_sale_id');
    }

    protected $dates = ['start_time', 'end_time'];

    public function setStartTimeAttribute($v)
    {
        $this->attributes['start_time'] = Carbon::createFromFormat('h:i a', $v)->format('h:i a');
    }

    public function getStartTimeAttribute($v)
    {
        return Carbon::createFromFormat('h:i a', $v)->format('h:i a');
    }

    public function setEndTimeAttribute($v)
    {
        $this->attributes['end_time'] = Carbon::createFromFormat('h:i a', $v)->format('h:i a');
    }

    public function getEndTimeAttribute($v)
    {
        return Carbon::createFromFormat('h:i a', $v)->format('h:i a');
    }
}
