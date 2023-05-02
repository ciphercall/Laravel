<?php

namespace App\Observers;

use App\Models\SellerBusinessAddress;
use App\Models\SellerProfile;
use App\Models\SellerReturnAddress;
use App\Seller;

class SellerObserver
{
    /**
     * Handle the = seller "created" event.
     *
     * @param  \App\=Seller  $=Seller
     * @return void
     */
    public function created(Seller $seller)
    {
        SellerProfile::create([
            'seller_id' => $seller->id,
            'proprietor_name' => $seller->name,
            'registration_number' => '1',
            'crporate_address ' => '1',
            'vat_registration_number ' => '1',
            'nid_number' => '1',
            'trade_licenses' => '1',
            'main_business' => '1',
            'product_category' => '1',
            'corporate_number' => '1',
            'address' => '1',
            'location_details' => '1',
            'division' => '1',
            'city' => '1',
            'postcode' => '1'
        ]);

        SellerReturnAddress::create([
            'seller_id' => $seller->id,
            'return_address' => 'Your Return Address',
            'return_division' => 3,
            'return_city' => 202,
            'return_postcode' => 272,
        ]);

        SellerBusinessAddress::create([
            'seller_id' => $seller->id,
            'business_address' => 'Your Business Address',
            'business_division' => 3,
            'business_city' => 202,
            'business_postcode' => 272,
        ]);
    }

    /**
     * Handle the = seller "updated" event.
     *
     * @param  \App\=Seller  $=Seller
     * @return void
     */
    public function updated(Seller $seller)
    {
        //
    }

    /**
     * Handle the = seller "deleted" event.
     *
     * @param  \App\=Seller  $=Seller
     * @return void
     */
    public function deleted(Seller $seller)
    {
        //
    }

    /**
     * Handle the = seller "restored" event.
     *
     * @param  \App\=Seller  $=Seller
     * @return void
     */
    public function restored(Seller $seller)
    {
        //
    }

    /**
     * Handle the = seller "force deleted" event.
     *
     * @param  \App\=Seller  $=Seller
     * @return void
     */
    public function forceDeleted(Seller $seller)
    {
        //
    }
}
