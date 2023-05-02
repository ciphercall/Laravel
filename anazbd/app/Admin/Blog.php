<?php

namespace App\Admin;

use App\Traits\AutoTimeStamp;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	use Sluggable ,AutoTimeStamp;
	
    // protected $guarded = ['id'];
    protected $fillable = ['title','description','large_image','short_image','admin_id','slug','top'];

    public function admin( )
    {
    	return $this->belongsTo('App\Admin','admin_id');
    }
}
