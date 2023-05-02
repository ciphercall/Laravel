<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColInChalans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chalans', function (Blueprint $table) {
            $table->enum('status',['Pending','Delivered','Not Delivered'])->default('Pending')->after('total');
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
            $table->dropColumn('status');
        });
    }
}
