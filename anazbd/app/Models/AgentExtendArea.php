<?php

namespace App\Models;
use App\Traits\AutoTimeStamp;
use App\Models\Agent;

use Illuminate\Database\Eloquent\Model;

class AgentExtendArea extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function postCode()
    {
        return $this->belongsTo(PostCode::class, 'post_id');
    }
}
