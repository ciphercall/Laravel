<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class, 'division_id');
    }

    public function areas()
    {
        return $this->hasMany(PostCode::class, 'division_id');
    }
}
