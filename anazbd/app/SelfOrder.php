<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfOrder extends Model
{
    protected $fillable = [
        'name','user_id','mobile','address','status'
    ];

    function images(){
        return $this->hasMany(SelfOrderImage::class);
    }
}
