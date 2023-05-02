<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $fillable = [
        'title','body','sent_to','image','admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
