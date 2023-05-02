<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnazSellerAndOrderColsInSellers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->tinyInteger('is_anazmall_seller')->default(0)->after('slug');
            $table->integer('anazmall_order')->nullable()->after('is_anazmall_seller');
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
            $table->dropColumn('is_anazmall_seller');
            $table->dropColumn('anazmall_order');
        });
    }
}
