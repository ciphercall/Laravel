<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Division;
use App\Models\Item;
use App\Models\PostCode;
use App\Models\SellerProfile;
use App\Models\SellerBusinessAddress;
use App\Models\SellerReturnAddress;
use Illuminate\Http\Request;
use App\Seller;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use NabilAnam\SimpleUpload\SimpleUpload;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{

    public function index()
    {
        $sellers = Seller::paginate(20);
        return view('backend.seller.index', compact('sellers'));
    }


    public function create()
    {
        return view('admin.users.sellers.create');
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'name'      => 'required|unique:sellers,name',
        //     'mobile'    => 'required|string',
        //     'type'      => 'required',
        //     'shop_name '=> 'required|unique:sellers,shop_name',
        //     'password ' => 'required',
        // ]);

        $data               = $request->all();
        $data['password']   = Hash::make(trim($request->password));
        try{
            DB::beginTransaction();
            $seller = Seller::create($data);
            // dd($seller);
            // $this->createOtherFieldsForSeller($seller->id);
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            dd($e);
        }
        // dd($seller);
        return redirect()->route('admin.users.sellers')->with('message','Seller Added Successfully');

    }
    public function createOtherFieldsForSeller($id)
    {
        SellerProfile::create([
            'seller_id'               => $id,
            'proprietor_name'         => '1',
            'registration_number'     => '1',
            'crporate_address'        => '1',
            'vat_registration_number' => '1',
            'nid_number'              => '1',
            'trade_licenses'          => '1',
            'main_business'           => '1',
            'product_category'        => '1',
            'corporate_number'        => '1',
            'address'                 => 'Dhaka',
            'location_details'        => '1',
            'division'                => '3',
            'city'                    => '98',
            'postcode'                => '607'
        ]);
        SellerReturnAddress::create([
            'seller_id'       => $id,
            'return_address'  => 'Dhaka',
            'return_division' => '3',
            'return_city'     => '98',
            'return_postcode' => '607'
        ]);
        SellerBusinessAddress::create([
            'seller_id'         => $id,
            'business_address'  => 'Dhaka',
            'business_division' => '3',
            'business_city'     => '98',
            'business_postcode' => '607'
        ]);
    }
    public function premium()
    {
        $sellers = Seller::orderByDesc('premium_order')->get(['id', 'name']);
        $premiums = Seller::where('is_premium', true)->orderBy('premium_order')->get();

        return view('admin.users.sellers.premium', compact('sellers', 'premiums'));
    }
    public function anazmall_seller(){
        $sellers = Seller::orderByDesc('anazmall_order')->get(['id', 'name']);
        $anazmall_sellers = Seller::where('is_anazmall_seller',true)->orderBy('anazmall_order')->get();

        return view('admin.users.sellers.anazmall',compact('sellers', 'anazmall_sellers'));
    }

    public function update_premium(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|numeric',
            'status' => 'required|numeric'
        ]);
        $sellers = Seller::where('is_premium', true)->orderBy('premium_order')->get();
        // dd($request->all(),$sellers);

        foreach ($sellers as $key => $seller)
        {
            $seller->premium_order = $key + 1;
            $seller->update();
        }

        Seller::where('id', '!=', $request->seller_id)
            ->where('premium_order', $request->premium_order)
            ->update([
                'premium_order' => null,
                'is_premium' => false
            ]);

            $seller = Seller::find($request->seller_id);
            $seller->is_premium = $request->status;
            $seller->premium_order = $request->premium_order;
            $seller->update();

        return back();
    }
    public function update_anazmall_seller(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        $sellers = Seller::where('is_anazmall_seller', true)->orderBy('anazmall_order')->get();
        // dd($request->all(),$sellers);

        foreach ($sellers as $key => $seller)
        {
            $seller->anazmall_order = $key + 1;
            $seller->update();
        }

        Seller::where('id', '!=', $request->seller_id)
            ->where('anazmall_order', $request->anazmall_order)
            ->update([
                'anazmall_order' => null,
                'is_anazmall_seller' => false
            ]);

            $seller = Seller::find($request->seller_id);
            $seller->is_anazmall_seller = $request->status;
            $seller->anazmall_order = $request->anazmall_order;
            $seller->update();

        return back();
    }

    public function search (Request $request)
    {
        $data     = $request->search;
        $sellers    = Seller::where('name', 'LIKE', '%' . $data .'%')
                    ->orWhere('mobile', 'LIKE', '%' . $data .'%')
                    ->orWhere('email', 'LIKE', '%' . $data .'%')
                    ->orWhere('shop_name', 'LIKE', '%' . $data .'%')
                    ->latest()
                    ->paginate(25);

        return view('admin.users.sellers.index',compact('sellers'));
    }

    public function status(Request $request, $id)
    {
        $seller = Seller::find($id);
        $seller->status = $request->status == "true" ? 1 : 0;
//        echo $seller->status;
        $seller->update();
        if($seller->status === 1){
            Item::withTrashed()->where('seller_id',$seller->id)->update([
                'deleted_at' => null
            ]);
        }else{
            Item::where('seller_id',$seller->id)->update([
                'deleted_at' => now()
            ]);
        }
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function show($id)
    {
        $seller             = SellerProfile::where('seller_id',$id)->first();
        $businessAddress    = SellerBusinessAddress::where('seller_id',$seller->seller_id)->first();
        $returnAddress      = SellerReturnAddress::where('seller_id',$seller->seller_id)->first();
        $cities             = City::get(['id','name']);
        $divisions          = Division::get(['id','name']);
        $allArea            = PostCode::get(['id','name']);

       return view('admin.users.sellers.edit',compact('cities','divisions', 'allArea','seller','businessAddress','returnAddress'));
    }

    public function edit($id){
        $seller             = SellerProfile::with('seller')->where('seller_id',$id)->first();
        $businessAddress    = SellerBusinessAddress::where('seller_id',$seller->seller_id??-1)->first();
        $returnAddress      = SellerReturnAddress::where('seller_id',$seller->seller_id??-1)->first();
        $cities             = City::get(['id','name']);
        $divisions          = Division::get(['id','name']);
        $allArea            = PostCode::get(['id','name']);

        return view('admin.users.sellers.edit',compact('cities','divisions', 'allArea','seller','businessAddress','returnAddress'));


    }
    public function update (Request $request, $id)
    {
        // dd($request->all());
        $seller_profile = SellerProfile::find($id);
        $seller_id      = $seller_profile->seller_id;
        $logo           = (new SimpleUpload)->file($request->seller_logo)
                            ->dirName('sellers')
                            ->deleteIfExists($seller_profile->logo)
                            ->save();
        $product_image = (new SimpleUpload)->file($request->product_image)
                            ->dirName('sellers')
                            ->deleteIfExists($seller_profile->product_image)
                            ->save();

        $seller_profile->update([
            'seller_id'               => $seller_id,
            'proprietor_name'         => $request->proprietor_name,
            'registration_number'     => $request->registration_number,
            'crporate_address'        => $request->crporate_address,
            'vat_registration_number' => $request->vat_registration_number,
            'nid_number'              => $request->nid_number,
            'trade_licenses'          => $request->trade_licenses,
            'main_business'           => $request->main_business,
            'product_category'        => $request->product_category,
            'corporate_number'        => $request->corporate_number,
            'location_details'        => $request->location_details,
            'address'                 => $request->address,
            'division'                => $request->division,
            'city'                    => $request->city,
            'postcode'                => $request->postcode,
            'logo'                    => $logo,
            'product_image'           => $product_image
        ]);
        $seller_profile->seller->update([
            'commission' => $request->commission,
            'commission_type' => $request->commission_type,
            'is_commission_based_on_product' => $request->is_commission_based_on_product == 'true' ? 1 : 0,
            'charge' => $request->charge,
            'delivery_charge' => $request->delivery_charge
        ]);
        $this->updateSellerBusinessAddress($request, $seller_id);
        $this->updateSellerReturnAddress($request, $seller_id);

        return back()->with('message','Data Updated Successfully.');
    }
    public function destroy(Seller $seller)
    {
       try {
            SellerBusinessAddress::where('seller_id',$seller->id)->delete();
            SellerReturnAddress::where('seller_id',$seller->id)->delete();
            $seller->delete();
       } catch (\Exception  $e) {
        //    dd($e);
            return back()->with('message',"Sorry can't Deleted.");
       }
       return back()->with('message','Seller Deleted Successfully');
    }

    public function updateSellerBusinessAddress($request, $seller_id) {
        if (isset($seller_id)){
            $data = array(
                'seller_id'         => $seller_id,
                'business_address'  => $request->business_address,
                'business_division' => $request->business_division,
                'business_city'     => $request->business_city,
                'business_postcode' => $request->business_postcode,
            );
            SellerBusinessAddress::where('seller_id',$seller_id)->update($data);
        }
    }

    public function updateSellerReturnAddress($request, $seller_id) {
        if (isset($seller_id)){
            $data = array(
                'seller_id'         => $seller_id,
                'return_address'    => $request->return_address,
                'return_division'   => $request->return_division,
                'return_city'       => $request->return_city,
                'return_postcode'   => $request->return_postcode,
            );
            SellerReturnAddress::where('seller_id',$seller_id)->update($data);
        }
    }


}
