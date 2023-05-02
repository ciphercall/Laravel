<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class DeliverySize extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];
}
