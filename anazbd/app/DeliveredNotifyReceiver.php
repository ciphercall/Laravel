<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveredNotifyReceiver extends Model
{
    protected $fillable = [
        'mobile','email','status','name'
    ];
}
