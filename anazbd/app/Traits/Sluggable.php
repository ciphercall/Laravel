<?php

namespace App\Traits;

use App\Models\ChildCategory;
use App\Models\Item;
use App\Models\SubCategory;
use App\Seller;
use Vinkla\Hashids\Facades\Hashids;

trait Sluggable
{
    public static function bootSluggable()
    {
        static::saving(function ($model) {
            $separator = '-';
            if (get_class($model) == SubCategory::class) {
                $model->slug = az_slug($model->category->name . $separator . $model->name);
            } else if (get_class($model) == ChildCategory::class) {
                $model->slug = az_slug($model->category->name .
                    $separator .
                    $model->sub_category->name .
                    $separator .
                    $model->name
                );
            } else if (get_class($model) == Item::class) {
                $model->slug = az_slug(
                    $model->name
                    . $separator
                    . Hashids::encode($model->seller_id . $model->id . $model->category_id . $model->sub_category_id)
                );
            } else if (get_class($model) == Seller::class) {
                $model->slug = az_slug($model->shop_name);
            } else if ($model->name) {
                $model->slug = az_slug($model->name);
            }
            else if ($model->title) {
                $model->slug = az_slug($model->title);
            }
        });
    }
}
