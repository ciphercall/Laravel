<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];
    protected $fillable = ['name','logo','address','email','mobile','short_desc','meta_key','meta_desc'];
}
