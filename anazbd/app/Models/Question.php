<?php

namespace App\Models;

use App\Models\Answer;
use App\Seller;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'user_id','item_id','question','approved','seller_id'
    ];

    public function answer()
    {
        return $this->hasOne(Answer::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
