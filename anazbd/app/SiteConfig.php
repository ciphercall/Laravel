<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    protected $fillable = [
        'is_cashback_enabled',
        'cashback_amount',
        'is_cod_enabled',
        'is_point_reward_enabled',
        'point_unit'
    ];
    
}
