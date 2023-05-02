<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Item;
use App\Models\SubCategory;
use App\Repositories\Repository;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Coupon\Store as StoreRequest;
use App\Http\Requests\Admin\Coupon\Update as UpdateRequest;
use App\Models\CouponExtra;
use Exception;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    protected $model;

    public function __construct(Coupon $coupon)
    {
        $this->model = new Repository($coupon);
    }

    public function index()
    {
        $coupons = $this->model->getWithRelation(['couponExtra','couponExtra.couponable'],20);
        return view('admin.coupons.index',compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        if(!array_key_exists("is_active",$data)){
            $data["is_active"] = false;
        }else{
            $data["is_active"] = true;
        }
        try{
            DB::beginTransaction();
            $coupon = $this->model->create($data);
            if(is_array($data["coupon_on"]) && is_array($data["type"]) && is_array($data["value"])){
                for($i = 0; $i < count($data["coupon_on"]); $i++ ){
                    CouponExtra::create([
                        'coupon_id' => $coupon->id,
                        'type' => $data["type"][$i],
                        'value' => $data["value"][$i],
                        'couponable_id' => $data["couponable_id"][$i] == 0 ? null : $data["couponable_id"][$i],
                        'couponable_type' => $data["couponable_id"][$i] == 0 ? null : $this->couponOnModelify($data["couponable_type"][$i]),
                        'coupon_on' => $data["coupon_on"][$i],
                        'min_amount' => $data["minimum_amount"][$i]
                    ]);
                }
            }
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return redirect()->back()->withInput($data);
        }
        return redirect()->route('admin.campaign.coupons.index')->with('success','Coupon Added.');
        
    }

    public function edit($id)
    {
        $coupon = $this->model->show(['couponExtra','couponExtra.couponable'],$id);
        return view('admin.coupons.edit',compact('coupon'));
    }

    public function update(UpdateRequest $request,$id)
    {
        $data = $request->validated();
        dump($data);
        if(!array_key_exists("is_active",$data)){
            $data["is_active"] = false;
        }else{
            $data["is_active"] = true;
        }
        try{
            DB::beginTransaction();
            $this->model->update($data,$id);
            $coupon = $this->model->show(['couponExtra'],$id);
            if(is_array($data["coupon_on"]) && is_array($data["type"]) && is_array($data["value"])){
                for($i = 0; $i < count($data["coupon_on"]); $i++ ){
                    CouponExtra::updateOrCreate([
                        'id' => $data["couponExtra_id"][$i],
                        'coupon_id' => $coupon->id
                    ],[
                        'type' => $data["type"][$i],
                        'value' => $data["value"][$i],
                        'couponable_id' => $data["couponable_id"][$i] == 0 ? null : $data["couponable_id"][$i],
                        'couponable_type' => $data["couponable_id"][$i] == 0 ? null : $this->couponOnModelify($data["couponable_type"][$i] ?? ""),
                        'coupon_on' => $data["coupon_on"][$i],
                        'min_amount' => $data["minimum_amount"][$i]
                    ]);
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }
        return redirect()->route('admin.campaign.coupons.index')->with("success","Coupon Updated");
    }

    public function destroy($id)
    {
        $this->model->delete($id);
        return redirect()->back()->with("success","coupon deleted.");
    }

    public function helper(Request $request)
    {
        $this->validate($request,[
            'type' => 'required|string'
        ]);
        $data = $this->getData($request->type);
        return response()->json([
            "status" => $data != null ? "success" : "error",
            "type" => $request->type,
            "data" => $data
        ]);
    }

    private function getData($type = "")
    {
        $data = collect();
        switch ($type){
            case "Category":
                $data = DB::table((new Category())->getTable())->get();
                break;
            case "SubCategory":
                $data = DB::table((new SubCategory())->getTable())->get();
                break;
            case "ChildCategory":
                $data = DB::table((new ChildCategory())->getTable())->get();
                break;
            case "Seller":
                $data = DB::table((new Seller)->getTable())->where('status',true)->get();
                break;
            case "User":
                $data = DB::table((new User)->getTable())->where('status',true)->get();
                break;
            case "Location":
                $data = DB::table((new City())->getTable())->get();
                break;
            case "Item":
                $data = DB::table((new Item)->getTable())->where('status',true)->get();
                break;
            default:
                $data = null;
        }
        return $data;
    }
    private function couponOnModelify(String $model)
    {
        switch ($model){
            case "Category":
                 return "App\Models\Category";
            case "SubCategory":
                return "App\Models\SubCategory";
            case "ChildCategory":
                return "App\Models\ChildCategory";
            case "Seller":
                return "App\Seller";
            case "User":
                return "App\User";
            case "Location":
                return "App\Models\City";
            case "Item":
                return "App\Models\Item";
            default:
                return $model;
        }
    }
}
