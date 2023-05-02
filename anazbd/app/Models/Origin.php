<?php

namespace App\Models;

use App\Traits\AutoDeleteFile;
use App\Traits\AutoTimeStamp;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    use AutoTimeStamp, Sluggable, AutoDeleteFile;

    protected $guarded = ['id'];

    private static function autoDeleteFileConfig()
    {
        return [
            'disk' => 'simpleupload',
            'attribute' => 'image'
        ];
    }
}
