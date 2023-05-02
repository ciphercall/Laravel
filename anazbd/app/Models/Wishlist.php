<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Wishlist extends Model
{
    // protected $guarded = 'id';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id','id');
    }
    // public function comments()
    // {
    //     return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
    // }
}
