<?php

namespace App\Traits;

use Carbon\Carbon;

trait AutoTimeStamp 
{
    public static function bootAutoTimeStamp()
    {
        static::creating(function ($model) {
            $model->fill([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        });
        static::updating(function ($model) {
            $model->fill([
                'updated_at' => Carbon::now(),
            ]);
        });
    }
}
