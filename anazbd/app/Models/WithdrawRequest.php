<?php

namespace App\Models;

use App\Seller;
use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use AutoTimeStamp, AuthScopes;

    protected $guarded = ['id'];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
