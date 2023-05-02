<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColsInCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('coupon_on');
            $table->dropColumn('on');
            $table->dropColumn('value');
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
            $table->enum('type',['percent','amount'])->default('amount');
            $table->decimal('value')->default(0);
            $table->enum('coupon_on',[
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
                ])->default('subtotal');
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
                ])->default('subtotal');
        });
    }
}
