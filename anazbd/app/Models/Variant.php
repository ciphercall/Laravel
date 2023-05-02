<?php

namespace App\Models;

use App\Traits\AutoDeleteFile;
use App\Traits\AutoTimeStamp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use AutoTimeStamp, AutoDeleteFile;

    protected $fillable = [
        'item_id', 'color_id', 'size_id', 'sku', 'qty', 'price', 'sale_price',
        'sale_start_day', 'sale_end_day', 'image', 'image_resized','mrp'
    ];

    protected $hidden = ['id', 'item_id', 'created_at', 'updated_at'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    // scopes
    public function scopeWhereCurrentDate($q)
    {
        $q->where('sale_start_day', '<=', date('Y-m-d'))
            ->where('sale_end_day', '>=', date('Y-m-d'));
    }

    public function scopeWhereNotCurrentDate($q)
    {
        $q->where('sale_start_day', null)
            ->orWhere('sale_end_day', null)
            ->orWhere('sale_end_day', '<', date('Y-m-d'))
            ->orWhere('sale_start_day', '>', date('Y-m-d'));
    }

    // attributes

    public function getPriceAttribute($val)
    {
        return round($val);
    }

    public function getFinalPriceAttribute()
    {
        return round($this->sale_price != null
        && $this->sale_start_day <= Carbon::today()->format('Y-m-d')
        && $this->sale_end_day >= Carbon::today()->format('Y-m-d')
            ? $this->sale_price : $this->price, 2);
    }

    private static function autoDeleteFileConfig()
    {
        return [
            'disk' => 'simpleupload',
            'attributes' => ['image', 'image_resized']
        ];
    }
}
