<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Items\StoreRequest;
use App\Http\Requests\Items\UpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Image;
use App\Models\Item;
use App\Models\ItemTag;
use App\Models\Origin;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\WarrantyType;
use App\Traits\ImageOperations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use NabilAnam\SimpleUpload\SimpleUpload;
use Intervention\Image\Facades\Image as InterventionImage;
class ItemController extends Controller
{
    use ImageOperations;
    public function index(Request $request)
    {
        $items = Item::whereAuthSeller()
            ->with('category', 'sub_category', 'brand')
            ->when($request->name, function ($q) use ($request) {
                $q->where('name', $request->name);
            })
            ->when($request->origin, function ($q) use ($request) {
                $q->where('origin_id', $request->origin);
            })
            ->when($request->brand, function ($q) use ($request) {
                $q->where('brand_id', $request->brand);
            })
            ->when($request->category, function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->when($request->sub_category, function ($q) use ($request) {
                $q->where('sub_category_id', $request->sub_category);
            })
            ->withCount('tags')
            ->latest()
            ->paginate(12);

        $brands = Brand::get(['id', 'name']);
        $categories = Category::get(['id', 'name']);
        $sub_categories = SubCategory::where('category_id', $request->category ?? -1)->get(['id', 'name']);

        return view('seller.items.index', compact('items', 'brands', 'categories', 'sub_categories'));
    }

    public function create()
    {
        $categories = Category::get(['id', 'name']);
        $brands = Brand::get(['id', 'name']);
        $units = Unit::get(['id', 'name']);
        $origins = Origin::get(['id', 'name']);
        $colors = Color::get(['id', 'name']);
        $sizes = Size::get(['id', 'name']);
        $tags  = Tag::orderByDesc('id')->get(['id', 'name']);
        $collections  = Collection::get(['title','id']);
        $warranty_types = WarrantyType::get(['id', 'name']);

        return view('seller.items.create', compact('categories', 'brands', 'units', 'origins', 'colors', 'sizes', 'warranty_types','tags','collections'));
    }

    public function store(StoreRequest $request)
    {
        $request->merge([
            'seller_id' => Auth::id(),
            'short_description' => trim($request->short_description),
            'digital_sheba' => $request->digital_sheba == 'on'
        ]);
        $uploads = null;

        try {
            DB::beginTransaction();

            // item
            $item = Item::create($request->all());
            // upload images
            $uploads = $this->uploadItemImages($request, $item);
            $item->feature_image = $uploads['feature_image'];
            $item->feature_image_resized = $uploads['feature_image_resized'];
            $item->thumb_feature_image = $uploads['thumb_feature_image'];
            $item->save();

            //create tag
            if ($request->tags) {
                $tags = explode(',', $request->tags);
                $tagsObj = [];
                foreach ($tags as $tag){
                    $tagsObj[] = Tag::updateOrCreate([
                        'name' => ucfirst($tag)
                    ],[
                        'name' => ucfirst($tag),
                        'status' => 1
                    ]);
                }
                $syncableTags = explode(',', collect($tagsObj)->implode('id', ','));
                $item->tags()->sync($syncableTags);

            }
            if ($request->tag_ids) {
                $item->tags()->sync($request->tag_ids);
            }

            // variants
            $combinations = [];
            $v_keys = [];
            foreach ($request->v_price as $key => $price) {
                // check duplicates
                $combination = $request->v_color_id[$key] . '-' . $request->v_size_id[$key];
                if (in_array($combination, $combinations)) {
                    continue;
                }
                $combinations[] = $combination;
                $v_keys[] = $key;

                // create variant
                Variant::updateOrCreate([
                    'item_id' => $item->id,
                    'color_id' => $request->v_color_id[$key],
                    'size_id' => $request->v_size_id[$key],
                ], [
                    'sku' => $request->v_sku[$key],
                    'qty' => $request->v_qty[$key],
                    'price' => $price,
                    'sale_price' => $request->v_sale_price[$key],
                    'sale_start_day' => $request->v_start_day[$key],
                    'sale_end_day' => $request->v_end_day[$key],
                    'image' => $uploads['v-' . $key] ?? null,
                    'image_resized' => $uploads['v-resized-' . $key] ?? null,
                ]);



            }

            // delete non required images
            foreach ($request->v_image ?? [] as $key => $image) {
                if (!in_array($key, $v_keys)) {
                    Storage::disk('simpleupload')->delete($uploads['v-' . $key]);
                    Storage::disk('simpleupload')->delete($uploads['v-resized-' . $key]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // delete all images
            dump($e);
            dd($uploads);
            if (is_array($uploads)) {
                foreach ($uploads as $image) {
                    Storage::disk('simpleupload')->delete($image);
                }
            }

            return redirect()
                ->route('seller.product.items.index')
                ->with('error', 'Item could not be added!');
        }

        return redirect()
            ->route('seller.product.items.index')
            ->with('message', 'Item Added Successfully!');
    }

    private function uploadItemImages(Request $request, $item)
    {
        // $upload = new SimpleUpload();
        $res = [];

        // feature images
        // $res['feature_image'] = $upload
        //     ->file($request->feature_image)
        //     ->dirName('product-feature')
        //     ->save();
        // dd($request->feature_image,InterventionImage::make($request->feature_image));
        if($request->hasFile('feature_image')){
            $res['feature_image'] = $this->saveImage("product",$request->feature_image,"product-feature",true);
            $res['thumb_feature_image'] = $this->saveImage("product",$this->resize($request->feature_image,300,300),"thumb-product-feature",false,"other");
            $res['feature_image_resized'] = $this->saveImage("product",$this->resize($request->feature_image,184,184),"product-feature-rsz",false,"other");

        }

        // $res['thumb_feature_image'] = $upload
        //     ->dirName('product-feature-thumb')
        //     ->resizeImage(300, 300)
        //     ->save();

        // $res['feature_image_resized'] = $upload
        //     ->dirName('product-feature-rsz')
        //     ->resizeImage(184, 184)
        //     ->save();

        // variant images
        if ($request->v_image) {
            foreach ($request->v_image as $key => $image) {
                // $res['v-' . $key] = $upload
                //     ->file($image)
                //     ->resizeImage(null, null)
                //     ->dirName('product-variant')
                //     ->save();
                // $res['v-resized-' . $key] = $upload
                //     ->resizeImage(45, 30)
                //     ->dirName('product-variant-rsz')
                //     ->save();
                $res['v-'.$key] = $this->saveImage("product-variant",$image,"variant",true);
                $res['v-resized-'.$key] = $this->saveImage("product-variant",$this->resize($image,45,30),"variant",false,"other");

            }
        }

        // other images
        if ($request->other_image) {
            foreach ($request->other_image as $key => $other) {
                /*
                    ! Old System Starts
                */
                // $path = $upload
                //     ->file($other)
                //     ->resizeImage(null, null)
                //     ->dirName('product-other')
                //     ->save();

                // $path_resized = $upload
                //     ->resizeImage(45, 30)
                //     ->dirName('product-other-rsz')
                //     ->save();
                /*
                    ! Old system ends
                */
                /*
                    ? New System
                */
                $path = $this->saveImage("product-other",$other,"other");
                $path_resized = $this->saveImage("product-other-rsz",$this->resize($other,45,30),"product-other",false,"other");

                $item->other_images()->create([
                    'path' => $path,
                    'path_resized' => $path_resized
                ]);

                $res['o-' . $key] = $path;
                $res['o-resized-' . $key] = $path_resized;
            }
        }

        return $res;
    }

    public function edit($id)
    {
        $item = Item::with('variants','tags')->find($id);
        // $tags = Tag::orderByDesc('id')->get(['id', 'name']);
        $categories = Category::get(['id', 'name']);
        $sub_categories = SubCategory::where('category_id', $item->category_id)->get(['id', 'name']);
        $child_categories = ChildCategory::where('subcategory_id', $item->sub_category_id)->get(['id', 'name']);

        $brands = Brand::get(['id', 'name']);
        $units = Unit::get(['id', 'name']);
        $origins = Origin::get(['id', 'name']);
        $colors = Color::get(['id', 'name']);
        $sizes = Size::get(['id', 'name']);
        $colls = Collection::get(['id', 'title']);
        $warranty_types = WarrantyType::get(['id', 'name']);

        return view('seller.items.edit', compact('item', 'categories', 'sub_categories',
            'child_categories', 'brands', 'units', 'origins', 'colors', 'sizes', 'warranty_types','colls'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $uploads = [];
        try {
            DB::beginTransaction();
            // dd($request->all());
            // item
            Item::where('id', $id)->update([
                'unit_id' => $request->unit_id,
                'origin_id' => $request->origin_id,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'collection_id' => $request->collection_id,
                'sub_category_id' => $request->sub_category_id,
                'child_category_id' => $request->child_category_id,
                'name' => $request->name,
                'slug' => az_slug($request->name),
                'warranty_type_id' => $request->warranty_type_id,
                'warranty_period' => $request->warranty_period,
                'warranty_policy' => $request->warranty_policy,
                'highlights' => $request->highlights,
                'description' => $request->description,
                'short_description' => trim($request->short_description),
                'digital_sheba' => $request->digital_sheba == 'on'
            ]);
            $item = Item::find($id);
            $old_images = [];

            //update tag
            if ($request->tags) {
                $tags = explode(',', $request->tags);
                $tagsObj = [];
                foreach ($tags as $tag) {
                    $tagsObj[] = Tag::updateOrCreate([
                        'name' => ucfirst($tag)
                    ], [
                        'name' => ucfirst($tag),
                        'status' => 1
                    ]);
                }
                $syncableTags = explode(',', collect($tagsObj)->implode('id', ','));
                $item->tags()->sync($syncableTags);
            }
            if ($request->tag_ids) {
                $item->tags()->sync($request->tag_ids);
            }
            // upload images
            $uploads = $this->updateItemImages($request, $item);
            if(count($uploads) > 0){
                $old_images[] = $uploads['feature_image'] != null ? $item->feature_image : null;
                $old_images[] = $uploads['feature_image_resized'] != null ? $item->feature_image_resized : null;
                $old_images[] = $uploads['thumb_feature_image'] != null ? $item->thumb_feature_image : null;
                $item->feature_image = $uploads['feature_image'] ?? $item->feature_image;
                $item->feature_image_resized = $uploads['feature_image_resized'] ?? $item->feature_image_resized;
                $item->thumb_feature_image = $uploads['thumb_feature_image'] ?? $item->thumb_feature_image;
            }
            $item->update();


            // update other images
            foreach ($request->other_image ?? [] as $key => $image) {
                $image = Image::where('id', $key)->first();
                $old_images[] = $image->path;
                $old_images[] = $image->path_resized;
                $image->update([
                    'path' => $uploads['o-' . $key],
                    'path_resized' => $uploads['o-resized-' . $key],
                ]);
            }

            // update variants
            $combinations = [];
            Variant::where('item_id', $id)->whereNotIn('id', array_keys($request->v_price))->delete();
            foreach ($request->v_price ?? [] as $key => $price) {
                $combinations[] = $request->v_color_id[$key] . '-' . $request->v_size_id[$key];

                $variant = Variant::where('item_id', $id)->find($key);
                $old_images[] = array_key_exists('v-' . $key, $uploads) ? $variant->image : null;
                $old_images[] = array_key_exists('v-' . $key, $uploads) ? $variant->image_resized : null;
                $variant->update([
                    'color_id' => $request->v_color_id[$key] ?? null,
                    'size_id' => $request->v_size_id[$key] ?? null,
                    'sku' => $request->v_sku[$key] ?? null,
                    'qty' => $request->v_qty[$key],
                    'price' => $price,
                    'sale_price' => $request->v_sale_price[$key] ?? null,
                    'sale_start_day' => $request->v_start_day[$key] ?? null,
                    'sale_end_day' => $request->v_end_day[$key] ?? null,
                    'image' => $uploads['v-' . $key] ?? $variant->image,
                    'image_resized' => $uploads['v-resized-' . $key] ?? $variant->image_resized,
                ]);
            }

            // create variants
            $new_v_keys = [];
            foreach ($request->new_v_price ?? [] as $key => $price) {
                // check duplicates
                $combination = $request->new_v_color_id[$key] . '-' . $request->new_v_size_id[$key];
                if (in_array($combination, $combinations)) {
                    continue;
                }
                $combinations[] = $combination;
                $new_v_keys[] = $key;

                // create variant
                Variant::updateOrCreate([
                    'item_id' => $item->id,
                    'color_id' => $request->new_v_color_id[$key],
                    'size_id' => $request->new_v_size_id[$key],
                ], [
                    'sku' => $request->new_v_sku[$key],
                    'qty' => $request->new_v_qty[$key],
                    'price' => $price,
                    'sale_price' => $request->new_v_sale_price[$key],
                    'sale_start_day' => $request->new_v_start_day[$key],
                    'sale_end_day' => $request->new_v_end_day[$key],
                    'image' => $uploads['new-v-' . $key] ?? null,
                    'image_resized' => $uploads['new-v-resized-' . $key] ?? null,
                ]);
            }

            DB::commit();

            // delete non required images
            foreach ($request->new_v_image ?? [] as $key => $image) {
                if (!in_array($key, $new_v_keys)) {
                    Storage::disk('simpleupload')->delete($uploads['nv-' . $key]);
                    Storage::disk('simpleupload')->delete($uploads['nv-resized-' . $key]);
                }
            }
            foreach ($old_images as $image) {
                Storage::disk('simpleupload')->delete($image);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dump($e);
            dd($uploads);
            // delete all images
            if (is_array($uploads)) {
                foreach ($uploads as $image) {
                    Storage::disk('simpleupload')->delete($image);
                }
            }
        }

        return redirect()
            ->route('seller.product.items.index')
            ->with('message', 'Item Updated Successfully!');
    }

    private function updateItemImages(Request $request, $item)
    {
        // $upload = new SimpleUpload();
        $res = [];
        // dd($request->all(),"update func");
        // feature images

        if($request->hasFile('feature_image')){
            $res['feature_image'] = $this->updateImage($item->feature_image,$request->feature_image,"product","product-feature",true);
            $res['thumb_feature_image'] = $this->updateImage($item->thumb_feature_image,$this->resize($request->feature_image,300,300),"product","thumb-product-feature",false,"other");
            $res['feature_image_resized'] = $this->updateImage($item->feature_image_resized,$this->resize($request->feature_image,184,184),"product","product-feature-rsz",false,"other");
        }else{
            $res['feature_image'] = null;
            $res['thumb_feature_image'] = null;
            $res['feature_image_resized'] = null;
        }
        // $res['feature_image'] = $upload
        //     ->file($request->feature_image)
        //     ->dirName('product-feature')
        //     ->save();

        // $res['thumb_feature_image'] = $upload
        //     ->dirName('product-feature-thumb')
        //     ->resizeImage(300, 300)
        //     ->save();

        // $res['feature_image_resized'] = $upload
        //     ->dirName('product-feature-rsz')
        //     ->resizeImage(184, 184)
        //     ->save();

        // variant images
        foreach ($request->v_image ?? [] as $key => $image) {
            $res['v-'.$key] = $this->saveImage("product-variant",$image,"variant",true);
            $res['v-resized-'.$key] = $this->saveImage("product-variant",$this->resize($image,45,30),"variant",false,"other");
        }
        foreach ($request->new_v_image ?? [] as $key => $image) {
            // $res['nv-' . $key] = $upload
            //     ->file($image)
            //     ->resizeImage(null, null)
            //     ->dirName('product-variant')
            //     ->save();
            // $res['nv-resized-' . $key] = $upload
            //     ->resizeImage(45, 30)
            //     ->dirName('product-variant-rsz')
            //     ->save();
                $res['nv-'.$key] = $this->saveImage("product-variant",$image,"variant");
                $res['nv-resized-'.$key] = $this->saveImage("product-variant",$this->resize($image,45,30),"variant",false,"other");
        }

        // other images
        foreach ($request->new_other_image ?? [] as $key => $other) {

            $path = $this->saveImage("product-other",$other,"product-other");
            $path_resized = $this->saveImage("product-other-rsz",$this->resize($other,45,30),"product-other",'false',"other");

            $item->other_images()->create([
                'path' => $path,
                'path_resized' => $path_resized
            ]);

            $res['no-' . $key] = $path;
            $res['no-resized-' . $key] = $path_resized;

            /*
                ! Old Image
            */
            // $path = $upload
            //     ->file($other)
            //     ->resizeImage(null, null)
            //     ->dirName('product-other')
            //     ->save();

            // $path_resized = $upload
            //     ->resizeImage(45, 30)
            //     ->dirName('product-other-rsz')
            //     ->save();

            // $item->other_images()->create([
            //     'path' => $path,
            //     'path_resized' => $path_resized
            // ]);

            // $res['no-' . $key] = $path;
            // $res['no-resized-' . $key] = $path_resized;
        }
        foreach ($request->other_image ?? [] as $key => $other) {
            $path = $this->saveImage("product-other",$other,"product-other");
            $path_resized = $this->saveImage("product-other-rsz",$this->resize($other,45,30),"product-other",false,"other");

            $item->other_images()->create([
                'path' => $path,
                'path_resized' => $path_resized
            ]);

            $res['o-' . $key] = $path;
            $res['o-resized-' . $key] = $path_resized;
            // $path = $upload
            //     ->file($other)
            //     ->resizeImage(null, null)
            //     ->dirName('product-other')
            //     ->save();

            // $path_resized = $upload
            //     ->resizeImage(45, 30)
            //     ->dirName('product-other-rsz')
            //     ->save();

            // $res['o-' . $key] = $path;
            // $res['o-resized-' . $key] = $path_resized;
        }

        return $res;
    }

    public function deleteOtherImage($item_id, $image_id)
    {
        $image = Image::where('imageable_type', 'App\Models\Item')
            ->where('imageable_id', $item_id)
            ->where('id', $image_id)
            ->first();

        $image->delete();

        return back()->with('message', 'Item image deleted successfully!');
    }

    public function destroy($id)
    {
        //delete images with trait
        try {
            DB::beginTransaction();
            $variants = Variant::where('item_id', $id)->get();
            foreach ($variants as $variant) {
                $variant->delete();
            }

            $item = Item::with('other_images')->find($id);
            foreach ($item->other_images as $image) {
                $image->delete();
            }


            $item->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('seller.product.items.index')
                ->with('error', 'Item is referenced in another place!');
        }

        return redirect()
            ->route('seller.product.items.index')
            ->with('message', 'Item Deleted Successfully!');
    }




    //    ajax
    public function ajaxGetSubCategories($category_id)
    {
        return response()->json(SubCategory::where('category_id', $category_id)->get(['id', 'name']));
    }

    public function ajaxGetChildCategories($subcategory_id)
    {
        return response()->json(ChildCategory::where('subcategory_id', $subcategory_id)->get(['id', 'name']));
    }

    public function saveImgAjax(Request $request){
//        $data = 'data:image/png;base64,AAAFBfj42Pj4';
        $data = $request->imageData;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $savedFilePath = 'image.png';

        file_put_contents($savedFilePath, $data);
//        echo $data;
        return $savedFilePath;

    }
}
