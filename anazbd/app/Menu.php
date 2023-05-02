<?php

namespace App;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name' , 'icon', 'route', 'parent_id', 'is_new_panel'
    ];

    public function submenus()
    {
        return $this->hasMany(Menu::class,'parent_id','id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
