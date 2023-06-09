<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    protected $fillable = [
        'user_id','amount','active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
