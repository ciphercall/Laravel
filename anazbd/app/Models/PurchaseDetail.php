<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
