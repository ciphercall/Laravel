<?php

namespace App\Models;


use App\Traits\AutoTimeStamp;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
   use Sluggable, AutoTimeStamp;

    protected $fillable = [
      'title',
      'cover_photo',
      'cover_photo_2',
      'cover_photo_3',
      'status',
      'show_in_home',
      'slug'
    ];


    public function items()
    {
        return $this->hasMany(Item::class, 'collection_id', 'id');
    }

}
