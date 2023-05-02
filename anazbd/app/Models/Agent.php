<?php

namespace App\Models;

use App\Delivery;
use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function AgentAllocatedArea()
    {
        return $this->hasMany(AgentAllocatedArea::class);
    }
    // public function allocated()
    // {
    //     return $this->belongsToMany(AgentAllocatedArea::class);
    // }

    public function AgentExtendArea()
    {
        return $this->hasMany(AgentExtendArea::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_agent_id');
    }

    function invoices(){
        return $this->hasMany(Chalan::class,'agent_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'agent_id');
    }

    // public function roles()
    // {
    //     return $this->belongsToMany('App\Role', 'role_user_table', 'user_id', 'role_id');
    // }
}
