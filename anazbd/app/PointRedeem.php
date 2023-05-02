<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointRedeem extends Model
{
    protected $fillable = [
        'user_id', 'status', 'value', 'code', 'valid_till'
    ];

    protected $dates = ['valid_till','created_at','updated_at'];
}
