<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['division_id', 'name'];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function areas()
    {
        return $this->hasMany(PostCode::class, 'city_id');
    }
}
