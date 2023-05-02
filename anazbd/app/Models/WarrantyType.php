<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyType extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(Item::class, 'warranty_type_id');
    }
}
