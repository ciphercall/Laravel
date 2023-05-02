<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChalanItem extends Model
{
    protected $fillable = [
        'chalan_id','item_id','price','subtotal','qty'
    ];

    public function chalan()
    {
        return $this->belongsTo(Chalan::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
