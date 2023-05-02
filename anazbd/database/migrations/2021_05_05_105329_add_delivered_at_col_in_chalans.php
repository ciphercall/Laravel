<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveredAtColInChalans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chalans', function (Blueprint $table) {
            $table->string('delivered_at')->nullable()->after('shipping_charge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chalans', function (Blueprint $table) {
            $table->dropColumn('delivered_at');
        });
    }
}
