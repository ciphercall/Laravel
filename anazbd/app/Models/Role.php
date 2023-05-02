<?php

namespace App\Models;

use App\Admin;
use App\Traits\AutoTimeStamp;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
