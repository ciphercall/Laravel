<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    protected $dates = ['purchase_date'];

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
