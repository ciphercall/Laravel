<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashReturn extends Model
{
    protected $fillable = [
        'user_id','amount','is_useable'
    ];
}
