<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreOrder extends Model
{
    protected $fillable = [
      'name','user_id','mobile','address'
    ];

}
