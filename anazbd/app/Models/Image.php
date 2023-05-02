<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use App\Traits\AutoDeleteFile;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use AutoTimeStamp, AutoDeleteFile;

    protected $guarded = ['id'];

    public function imageable()
    {
        return $this->morphTo();
    }

    private static function autoDeleteFileConfig()
    {
        return [
            'disk' => 'simpleupload',
            'attributes' => ['path', 'path_resized']
        ];
    }
}
