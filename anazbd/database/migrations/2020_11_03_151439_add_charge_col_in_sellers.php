<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChargeColInSellers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->unsignedInteger('charge')->default(0)->after('deleted_at');
            $table->tinyInteger('is_commission_based_on_product')->default(true)->after('charge');
            $table->integer('commission')->default(0)->after('is_commission_based_on_product');
            $table->enum('commission_type',['percent','taka'])->default('percent')->after('commission');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['charge','is_commission_based_on_product','commission','commission_type']);
        });
    }
}
