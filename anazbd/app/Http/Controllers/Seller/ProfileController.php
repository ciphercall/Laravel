<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerProfile\ProfileRequest;
use App\Models\City;
use App\Models\Division;
use App\Models\PostCode;
use App\Models\SellerBusinessAddress;
use App\Models\SellerProfile;
use App\Models\SellerReturnAddress;
use Illuminate\Http\Request;
use NabilAnam\SimpleUpload\SimpleUpload;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function getCityByDivision($divisionId) {
        $cities = City::where('division_id', $divisionId)->get();
        return  response()->json($cities);
    }

    public function getPostCodeByCity($cityId) {
        $postCode = PostCode::where('city_id', $cityId)->get();
        return  response()->json($postCode);
    }

    public function addSellerInfo(Request $request, $id = null, $businessId = null, $returnId=null)
    {
        $this->updateSellerBusinessAddress($request, $businessId);
        $this->updateSellerReturnAddress($request, $returnId);
        $sellerLogo     = $request->file('seller_logo');
        $product_image  = $request->file('product_image');
        $data = $request->all();

        if (isset($id)){
           $profileDetails = SellerProfile::find($id);
           if (isset($sellerLogo)) {
                $data['seller_logo'] = (new SimpleUpload)
                                     ->file($request->seller_logo)
                                     ->dirName('seller-logo')
                                     ->deleteIfExists($profileDetails->seller_logo)
                                     ->save();

                $data['logo']       = (new SimpleUpload)
                                    ->file($request->seller_logo)
                                    ->dirName('logo')
//                                    ->resizeImage(64,64)
                                    ->deleteIfExists($profileDetails->logo)
                                    ->save();
           }

           if(isset($product_image)){
                $data['product_image']= (new SimpleUpload)
                                    ->file($request->product_image)
                                    ->dirName('product_image')
//                                    ->resizeImage(203,203)
                                    ->deleteIfExists($profileDetails->product_image)
                                    ->save();
           }

            SellerProfile::find($id)->update($data);
        }else{
            SellerProfile::addSellerProfile($request);
        }

        return redirect('/seller/profile');

    }

    public function updateImage(Request $request, $id = null)
    {
        $sellerLogo     = $request->file('seller_logo');
        $product_image  = $request->file('product_image');
        $data = $request->all();
        if (isset($id)){
            $profileDetails = SellerProfile::find($id);
            if (isset($sellerLogo)) {
                $data['seller_logo'] = (new SimpleUpload)
                    ->file($request->seller_logo)
                    ->dirName('seller-logo')
                    ->deleteIfExists($profileDetails->seller_logo)
                    ->save();

                $data['logo']       = (new SimpleUpload)
                    ->file($request->seller_logo)
                    ->dirName('logo')
//                    ->resizeImage(64,64)
                    ->deleteIfExists($profileDetails->logo)
                    ->save();
            }

            if(isset($product_image)){
                $data['product_image']= (new SimpleUpload)
                    ->file($request->product_image)
                    ->dirName('product_image')
//                    ->resizeImage(203,203)
                    ->deleteIfExists($profileDetails->product_image)
                    ->save();
            }

            SellerProfile::find($id)->update($data);
        }else{
            echo "seller not found!!!";
        }

        return redirect('/seller/profile');
    }

    public function updateSellerBusinessAddress($request, $businessId){
        if (isset($businessId)){
            $data = array(
                'business_address'  => $request->business_address,
                'business_division' => $request->business_division,
                'business_city'     => $request->business_city,
                'business_postcode' => $request->business_postcode,
            );

            SellerBusinessAddress::find($businessId)->update($data);
        }else{
            SellerBusinessAddress::addSellerBusinessAddress($request);
        }
    }

    public function updateSellerReturnAddress($request, $returnId) {
        if (isset($returnId)){
            $data = array(
                'return_address'    => $request->return_address,
                'return_division'   => $request->return_division,
                'return_city'       => $request->return_city,
                'return_postcode'   => $request->return_postcode,
            );
            SellerReturnAddress::find($returnId)->update($data);
        }else{
            SellerReturnAddress::addSellerReturnAddress($request);
        }
    }


}
