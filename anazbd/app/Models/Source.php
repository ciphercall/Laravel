<?php

namespace App\Models;

use App\Traits\AutoDeleteFile;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use AutoTimeStamp, AutoDeleteFile;

    protected $guarded = ['id'];

    private static function autoDeleteFileConfig()
    {
        return [
            'disk' => 'simpleupload',
            'attribute' => 'image'
        ];
    }
}
