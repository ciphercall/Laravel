<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoTimeStamp;
use App\Traits\Sluggable;

class ChildCategory extends Model
{
    use AutoTimeStamp, Sluggable;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class,'child_category_id');
    }

    public function scopeWhereSubCategorySlug($q, $slug)
    {
        $q->whereHas('sub_category', function ($r) use ($slug) {
            $r->where('slug', $slug);
        });
    }
}
