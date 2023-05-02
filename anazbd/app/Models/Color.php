<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoTimeStamp;

class Color extends Model
{
    protected $guarded = ['id'];

    public function variants()
    {
        return $this->hasMany(Variant::class, 'color_id');
    }
}
