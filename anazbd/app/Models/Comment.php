<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['rating','review','item_id','user_id','status'];
    protected $hidden   = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function scopeStatus($query)
    {
        return $query->where('status', true);
    }

}
