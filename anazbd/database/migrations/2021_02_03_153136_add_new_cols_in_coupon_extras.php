<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColsInCouponExtras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_extras', function (Blueprint $table) {
            $table->enum('type',['percent','amount'])->default('amount')->after('coupon_id');
            $table->decimal('value')->default(0)->after('type');
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
                ])->default('subtotal')->after('value');

                $table->string('couponable_type')->nullable()->change();
                $table->unsignedBigInteger('couponable_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_extras', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('value');
            $table->dropColumn('coupon_on');
        });
    }
}
