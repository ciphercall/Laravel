<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfOrderImage extends Model
{
    protected $fillable = [
        'self_order_id', 'image'
    ];

    function pre_order(){
        return $this->belongsTo(SelfOrder::class);
    }
}
