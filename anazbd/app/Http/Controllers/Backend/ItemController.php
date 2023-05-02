<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Items\AdminUpdateRequest;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Collection;
use App\Models\Color;
use App\Models\DeliverySize;
use App\Models\Item;
use App\Models\Origin;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\WarrantyType;
use App\Models\Wishlist;
use App\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function unpublished(Request $request)
    {
        $data = $this->getFilterData(false);
        $data['items'] = $this->getItems($request, false);

        return view('backend.items.unpublished', $data);
    }

    public function published(Request $request)
    {
        $data = $this->getFilterData(true);
        $data['items'] = $this->getItems($request, true);

        return view('backend.items.published', $data);
    }

    public function editUnpublished($id)
    {
        return view('backend.items.edit-unpublished', $this->getEditData($id));
    }

    public function editPublished($id)
    {
        return view('backend.items.edit-published', $this->getEditData($id));
    }

    public function update(AdminUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            // item
            $item = Item::find($id);
            $item->update([
                'name' => $request->name,
                'slug' => az_slug(
                    $request->name . '-'
                    . az_hash($item->seller_id . $item->id . $item->category_id . $item->sub_category_id)
                ),
                'category_id' => $request->category_id,
                'collection_id' => $request->collection_id,
                'sub_category_id' => $request->sub_category_id,
                'child_category_id' => $request->child_category_id,
                'brand_id' => $request->brand_id,
                'unit_id' => $request->unit_id,
                'origin_id' => $request->origin_id,
                'delivery_size_id' => $request->delivery_size_id,
                'status' => $request->status,
                'digital_sheba' => $request->digital_sheba == 'on',
                'best_seller' => $request->best_seller == 'on',
                'max_orderable_qty' => $request->max_orderable_qty,
                'online_payable_type' => $request->online_payable_type,
                'is_online_pay_only' => $request->is_online_pay_only ? true : false,
            ]);

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

            // update variants
            $combinations = [];
            Variant::where('item_id', $id)->whereNotIn('id', array_keys($request->v_price))->delete();
            foreach ($request->v_price ?? [] as $key => $price) {
                $combinations[] = $request->v_color_id[$key] . '-' . $request->v_size_id[$key];

                $variant = Variant::where('item_id', $id)->find($key);
                $variant->update([
                    'color_id' => $request->v_color_id[$key] ?? null,
                    'size_id' => $request->v_size_id[$key] ?? null,
                    'sku' => $request->v_sku[$key] ?? null,
                    'qty' => $request->v_qty[$key],
                    'price' => $price,
                    'mrp' => $request->v_mrp[$key],
                    'sale_price' => $request->v_sale_price[$key] ?? null,
                    'sale_start_day' => $request->v_start_day[$key] ?? null,
                    'sale_end_day' => $request->v_end_day[$key] ?? null,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        $route = $request->status == "0" ? route('backend.product.items.unpublished.index') : route('backend.product.items.published.index');
        return redirect($request->redirect == null ? $route : $request->redirect)
            ->with('message', 'Item Updated Successfully!');
    }

    public function destroy($id)
    {
        //delete images with trait
        $item = null;
        try {
            DB::beginTransaction();
            // product delete from cart-item-table
            CartItem::where('item_id',$id)->delete();

            // product delete from Wishlist-item-table
            Wishlist::where('item_id',$id)->delete();

            $item = Item::with('other_images')->find($id);
            $variants = Variant::where('item_id', $id)->get();
            foreach ($variants as $variant) {
                $variant->delete();
            }

            foreach ($item->other_images as $image) {
                $image->delete();
            }

            $item->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                    ->route(
                        $item->status == "0"
                            ? 'backend.product.items.unpublished.index'
                            : 'backend.product.items.published.index'
                    )
                ->with('error', 'Item is referenced in another place!');
        }

        return redirect()
                ->route(
                    $item->status == "0"
                        ? 'backend.product.items.unpublished.index'
                        : 'backend.product.items.published.index'
                )
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

    // helpers
    private function getItems(Request $request, $status)
    {
        return Item::where('status', $status)
            ->with('sub_category', 'brand', 'category', 'seller')
            ->when($request->name, function ($q) use ($request) {
                $q->where('name', $request->name);
            })
            ->when($request->origin, function ($q) use ($request) {
                $q->where('origin_id', $request->origin);
            })
            ->when($request->brand, function ($q) use ($request) {
                $q->where('brand_id', $request->brand);
            })
            ->when($request->shop, function ($q) use ($request) {
                $q->where('seller_id', $request->shop);
            })
            ->when($request->category, function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->when($request->sub_category, function ($q) use ($request) {
                $q->where('sub_category_id', $request->sub_category);
            })
            ->latest()
            ->paginate(12);
    }

    private function getFilterData($status)
    {
        $data['brands'] = Brand::get(['id', 'name']);
        $data['categories'] = Category::with('sub_categories')->get(['id', 'name']);
        $data['sub_categories'] = SubCategory::where('category_id', $request->category ?? -1)->get(['id', 'name']);
        $data['shops'] = Seller::whereHas('items', function ($q) use ($status) {
            $q->where('status', $status);
        })->select('id', 'shop_name')->get();

        return $data;
    }

    private function getEditData($id)
    {
        $data['item'] = Item::with('variants')->find($id);
        $data['tags'] = Tag::get(['id', 'name']);
        $data['colls'] = Collection::get(['id', 'title']);
        $data['categories'] = Category::get(['id', 'name']);
        $data['sub_categories'] = SubCategory::where('category_id', $data['item']->category_id)->get(['id', 'name']);
        $data['child_categories'] = ChildCategory::where('subcategory_id', $data['item']->sub_category_id)->get(['id', 'name']);

        $data['brands'] = Brand::get(['id', 'name']);
        $data['units'] = Unit::get(['id', 'name']);
        $data['origins'] = Origin::get(['id', 'name']);
        $data['colors'] = Color::get(['id', 'name']);
        $data['sizes'] = Size::get(['id', 'name']);
        $data['warranty_types'] = WarrantyType::get(['id', 'name']);
        $data['delivery_sizes'] = DeliverySize::get(['id', 'name']);

        return $data;
    }
}
