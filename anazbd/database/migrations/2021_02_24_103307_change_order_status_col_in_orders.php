<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrderStatusColInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //        1. Order Pending
        //        2. Order Accept
        //        3. Product pickup from Seller
        //        4. Product Arrived at our Warehouse
        //        5. Quality Check
        //        6. Packing
        //        7. On Delivery
        //        8. Delivered
        //        9. Delivery Date enhanced
        //        10. Cancel

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status',[
                'Pending',
                'Accepted',
                'Pickup From Seller',
                'Arrived at Warehouse',
                'Quality Checking',
                'QC Failed',
                'Packing',
                'Cancelled',
                'On Delivery',
                'Delivered',
                'Delivered Date Enhanced',
                'Not Delivered'
            ])->default('Pending')->after('order_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
