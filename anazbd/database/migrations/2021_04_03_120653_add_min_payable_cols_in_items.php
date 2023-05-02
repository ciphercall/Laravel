<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinPayableColsInItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            // TODO: 1. online_payable_type (enum('delivery_charge','full_pay','half_pay'))
            $table->enum('online_payable_type',['delivery_charge','full_pay','half_pay'])->nullable()->after('slug');
            // $table->string('min_payable_amount')->default(0)->after('min_payable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('online_payable_type');
            // $table->dropColumn('min_payable_amount');
        });
    }
}
