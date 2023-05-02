<?php

namespace App\Models;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
