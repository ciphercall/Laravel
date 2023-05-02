<?php

namespace App\Models;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use AutoTimeStamp;
    
    protected $fillable = [
        'image','position',
    ];
}
