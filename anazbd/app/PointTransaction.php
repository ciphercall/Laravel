<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    // status = approved, pending, returned, cancelled
    protected $fillable = [
        'user_id','amount','previous_amount','status','type','note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
