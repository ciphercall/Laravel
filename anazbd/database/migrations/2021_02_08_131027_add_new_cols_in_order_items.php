<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColsInOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('discount')->default(0)->after('subtotal');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_breakdown')->nullable()->after('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_breakdown');
        });
    }
}
