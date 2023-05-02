<?php

namespace App\Models;

use App\Seller;
use App\Traits\AuthScopes;
use App\Traits\AutoDeleteFile;
use App\Traits\AutoTimeStamp;
use App\Traits\Sluggable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use AutoTimeStamp, Sluggable, AutoDeleteFile, AuthScopes, SoftDeletes;

    protected $fillable = [
        'name', 'seller_id', 'brand_id', 'category_id', 'sub_category_id', 'child_category_id', 'collection_id',
        'unit_id', 'origin_id', 'warranty_type_id', 'delivery_size_id', 'warranty_period', 'warranty_policy',
        'highlights', 'description', 'feature_image_resized', 'short_description', 'status', 'tag_id', 'rating',
        'best_seller', 'digital_sheba','max_orderable_qty','online_payable_type', 'is_online_pay_only'
    ];

    protected $hidden = [
        'id', 'seller_id', 'category_id', 'sub_category_id', 'child_category_id', 'unit_id', 'origin_id', 'tag_id', 'collection_id',
        'warranty_type_id', 'brand_id', 'created_at', 'updated_at'
    ];

    protected $appends = [
        'isWishlisted','original_price','sale_price'
    ];

    // relations
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class, 'origin_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function child_category()
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'item_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function warranty_type()
    {
        return $this->belongsTo(WarrantyType::class, 'warranty_type_id');
    }

    public function feature_image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function other_images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function Wishlist()
    {
        return $this->hasMany(Wishlist::class, 'item_id');
    }

    public function flash_sales()
    {
        return $this->hasMany(FlashSaleItem::class, 'item_id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id', 'id');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'item_id');
    }

    public function delivery_size()
    {
        return $this->belongsTo(DeliverySize::class, 'delivery_size_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'item_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    

    // scopes

    public function scopeOrderByPrice($q, $order = 'asc')
    {
        $q->orderBy(Variant::select('price')
            ->whereColumn('item_id', 'items.id')
            ->take(1), $order
        )
            ->orderBy(FlashSaleItem::select('sale_price')
                ->whereColumn('item_id', 'items.id')
                ->whereCurrentDateTime()
                ->take(1), $order
            )->orderBy(Variant::select('sale_price')
                ->whereColumn('item_id', 'items.id')
                ->take(1), $order
            );
    }

    public function scopeOrderByName($q, $order = 'asc')
    {
        $q->orderBy(
            Variant::select('name')
                ->whereColumn('item_id', 'items.id')
                ->take(1),
            $order
        );
    }

    public function scopeWhereCategorySlug($q, $slug)
    {
        $q->whereHas('category', function ($r) use ($slug) {
            $r->where('slug', $slug);
        });
    }

    public function scopeWhereSellerSlug($q, $slug)
    {
        $q->whereHas('seller', function ($r) use ($slug) {
            $r->where('slug', $slug);
        });
    }

    public function scopeWhereSubCategorySlug($q, $slug)
    {
        $q->whereHas('sub_category', function ($r) use ($slug) {
            $r->where('slug', $slug);
        });
    }

    public function scopeWhereChildCategorySlug($q, $slug)
    {
        $q->whereHas('child_category', function ($r) use ($slug) {
            $r->where('slug', $slug);
        });
    }

    public function scopeWhereBrandName($q, $name)
    {
        $q->whereHas('brand', function ($r) use ($name) {
            $r->where('name', $name);
        });
    }

    public function scopeWhereBrandSlug($q, $slug)
    {
        $q->whereHas('brand', function ($r) use ($slug) {
            $r->where('slug', $slug);
        });
    }

    public function scopeWhereColorName($q, $name)
    {
        $q->whereHas('variants.color', function ($r) use ($name) {
            $r->where('name', $name);
        });
    }

    public function scopeWhereHasActiveFlashSales($q)
    {
        $q->whereHas('flash_sales', function ($r) {
            $r->whereCurrentDateTime();
        });
    }

    public function scopeWhereHasDiscounts($q)
    {
        $q->whereHasActiveFlashSales()
            ->orWhereHas('variants', function ($r) {
                $r->whereCurrentDate()->where('sale_price', '>', 0)->take(1);
            });
    }

    public function scopeWherePrice($q, $min, $max)
    {
        $q->whereHas('flash_sales', function ($r) use ($min, $max) {
            $r->whereCurrentDateTime()
                ->whereBetween('sale_price', [$min ?? 0, $max ?? 99999999]);
        })->orWhereHas('variants', function ($r) use ($min, $max) {
            $r->whereIn('id', function ($s) {
                $s->selectRaw('min(id)')
                    ->from('variants')
                    ->whereColumn('item_id', 'items.id');
            })->where(function ($s) use ($min, $max) {
                $s->where(function ($t) use ($min, $max) {
                    $t->whereCurrentDate()
                        ->whereBetween('sale_price', [$min ?? 0, $max ?? 99999999]);
                })->orWhere(function ($t) use ($min, $max) {
                    $t->whereNotCurrentDate()
                        ->whereBetween('price', [$min ?? 0, $max ?? 99999999]);
                });
            });
        });
    }

    public function scopeCustomOrderBy($q, $filter, $orderType)
    {
        if ($filter == 'price') {
            $q->orderByPrice($orderType);
        } else if ($filter == 'name') {
            $q->orderByName($orderType);
        } else if ($filter == 'time') {
            $q->orderBy('created_at', $orderType);
        }
    }

    public function scopeWhereHasPremiumSeller($q)
    {
        $q->whereHas('seller', function ($r) {
            $r->where('is_premium', true);
        });
    }

    public function scopeWhereHasAnazSeller($q)
    {
        $q->whereHas('seller', function ($r) {
            $r->where('is_anazmall_seller', true);
        });
    }

    // attributes
    public function getCommissionAttribute($sub_category = null){
        if (!$sub_category)
            $sub_category = $this->sub_category;

        return $sub_category->commission ?? 0;
    }

    public function getIsWishlistedAttribute()
    {
       if(auth('web')->id()){
            $wishlist = auth('web')->user()->Wishlist;
            return $wishlist->contains($this->id);
       }elseif(auth('api')->id()){
            $wishlist = auth('api')->user()->Wishlist;
            // dd($wishlist->where('item_id',$this->id)->count());
            return $wishlist->where('item_id',$this->id)->count() > 0;
       }
       return false;
    }
    public function getOriginalPriceAttribute($variant = null)
    {
        if (!$variant)
            $variant = collect($this->variants)->first();
        $price = $variant->price;
        /* Price with addition Start */
        $price = round($variant->price + $this->getPriceAdditionAttribute($variant));
        $mrp = $variant->mrp;
        if($mrp)
            return $price > $mrp ? $mrp : $price;
        /* Price with addition End */
        return $price;

    }

    public function getSellerPriceAttribute($variant = null)
    {
        if(!$variant)
            return collect($this->variants)->first()->price;

        return $variant->price;
    }

    public function getSellerSalePriceAttribute($variant = null)
    {
        if(!$variant)
            return collect($this->variants)->first()->sale_price;

        return $variant->sale_price;
    }

    public function getSalePercentageAttribute($variant = null, $start_time = null)
    {
        if (!$variant)
            $variant = collect($this->variants)->first();

        if (!$start_time)
            $start_time = date('Y-m-d H:i:s');

        $sale_item = collect($this->flash_sales)
            ->where('start_time', '<=', $start_time)
            ->where('end_time', '>', $start_time)
            ->first();

        if ($sale_item)
            return round($sale_item->percentage);

        if ($variant && $variant->sale_start_day <= $start_time && $variant->sale_end_day >= $start_time)
            return round((($variant->price - $variant->sale_price) / $variant->price) * 100, 1);

        return 0;
    }

    public function getSaleStartDayAttribute($variant = null)
    {
        if (!$variant)
            $variant = collect($this->variants)->first();

        return $variant->sale_start_day;
    }

    public function getSaleEndDayAttribute($variant = null)
    {
        if (!$variant)
            $variant = collect($this->variants)->first();

        return $variant->sale_end_day;
    }

    public function getSalePriceAttribute($variant = null, $start_time = null)
    {
        if (!$start_time)
            $start_time = date('Y-m-d H:i:s');

        if (!$variant)
            $variant = collect($this->variants)->first();

        $percentage = $this->getSalePercentageAttribute($variant, $start_time);
        $original_price = $this->getOriginalPriceAttribute($variant);
        if ($percentage) {
            return round($original_price - ($original_price * ($percentage / 100)));
        }

        return 0;
    }
    public function getSaleAmountAttribute($variant = null)
    {
        if($variant == null)
        $variant = collect($this->variants)->first();

        return $variant->sale_price;
    }
    public function getPriceAttribute($variant = null, $start_time = null)
    {
        $sale_percentage = $this->getSalePercentageAttribute($variant, $start_time);

        if ($sale_percentage > 0)
            return $this->getSalePriceAttribute($variant, $start_time) ;

        return $this->getOriginalPriceAttribute($variant) ;
    }

    public function getPriceAdditionAttribute($variant = null, $start_time = null){
        return 0;
        /* Price addition Start */
        $seller = $this->seller;

        if($variant == null)
            $variant = collect($this->variants)->first();

        $price = $variant->price;

        $sellerCharge = $seller->charge ?? 0;
        // $deliveryCharge = $this->delivery_charge ?? 0;
        if(!$seller->is_commission_based_on_product){
            $commission = $seller->getSellerCommissionAttribute($price);
            $vat = $commission * (5/100);
            $deliveryCharge = ($price * ($seller->delivery_charge/100));
            $addition = $sellerCharge + $deliveryCharge + $commission + $vat;
            return round($addition);
        }
        $deliveryCharge = ($price * ($this->sub_category->delivery_charge/100));
        $commission = ($price * ($this->sub_category->commission /100));
        $vat = $commission * ($this->sub_category->vat/100);
        return round($vat + $commission + $sellerCharge + $deliveryCharge);
        /* Price addition End */
    }

    public function getIsFlashSaleAttribute()
    {
        return collect($this->flash_sales)
            ->where('start_time', '<=', date('Y-m-d H:i:s'))
            ->where('end_time', '>', date('Y-m-d H:i:s'))
            ->first() ? true : false;
    }

    // config

    private static function autoDeleteFileConfig()
    {
        return [
            'disk' => 'simpleupload',
            'attributes' => ['feature_image', 'feature_image_resized']
        ];
    }
}
