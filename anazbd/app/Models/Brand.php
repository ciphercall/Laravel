<?php

namespace App\Models;

use App\Traits\AutoDeleteFile;
use App\Traits\AutoTimeStamp;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use AutoTimeStamp, Sluggable, AutoDeleteFile;

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(Item::class, 'brand_id');
    }

    private static function autoDeleteFileConfig()
    {
        return [
            'disk' => 'simpleupload',
            'attribute' => 'image'
        ];
    }
}
