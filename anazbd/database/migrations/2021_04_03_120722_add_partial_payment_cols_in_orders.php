<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartialPaymentColsInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // TODO: 1. two cols partial_payment (bool type) 2. partial_pay_amount (int type)
            $table->boolean('partial_payment')->default(0)->after('total');
            $table->string('partial_payment_amount')->default(0)->after('partial_payment');
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
            $table->dropColumn('partial_payment');
            $table->dropColumn('partial_payment_amount');
        });
    }
}
