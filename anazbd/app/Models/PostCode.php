<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCode extends Model
{
    protected $fillable = ['division_id', 'city_id', 'name'];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
