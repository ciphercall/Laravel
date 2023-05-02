<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait AutoDeleteFile
{
  public static function bootAutoDeleteFile()
  {
    static::deleting(function ($model) {
      $config = static::autoDeleteFileConfig();
      if (array_key_exists('attributes', $config)) {
        foreach ($config['attributes'] as $attribute) {
          if (Storage::disk($config['disk'])->exists($model->{$attribute})) {
            Storage::disk($config['disk'])->delete($model->{$attribute});
          }
        }
      } else if (Storage::disk($config['disk'])->exists($model->{$config['attribute']})) {
        Storage::disk($config['disk'])->delete($model->{$config['attribute']});
      }
    });
  }
}
