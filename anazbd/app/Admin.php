<?php

namespace App;

use App\Traits\AutoTimeStamp;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Blog;
use App\Models\Role;
use App\Traits\HasPermissionsTrait;

class Admin extends Authenticatable
{
    use Notifiable, AutoTimeStamp, HasPermissionsTrait;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password','is_super'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function blogs($value='')
    {
    	return $this->hasMany(Blog::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
