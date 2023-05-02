<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponOnColInCoupons extends Migration
{
     /* 
            Coupon effect on Checklist
            
            1. Categories
            2. sub categories
            3. users
            4. location
            5. product
            6. seller
            7. anaz empire
            8. anaz spotlight
            9. Child category
            10. Subtotal
            11. delivery charge
        */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
           
            $table->enum('on',[
                'Category',
                'SubCategory',
                'ChildCategory',
                'Seller',
                'User',
                'Location',
                'Item',
                'anaz_empire',
                'anaz_spotlight',
                'subtotal',
                'delivery_charge'
                ])->default('subtotal')->after('coupon_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('on');
        });
    }
}
