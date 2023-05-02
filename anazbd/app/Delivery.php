<?php

namespace App;

use App\Models\Agent;
use App\Traits\AutoTimeStamp;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Delivery extends Authenticatable
{
    use Notifiable, AutoTimeStamp;

    protected $guard = 'delivery';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function agent()
    {
        return $this->hasOne(Agent::class, 'delivery_id', 'id');
    }
}
