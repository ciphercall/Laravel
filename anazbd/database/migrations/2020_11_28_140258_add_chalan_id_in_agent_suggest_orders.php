<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChalanIdInAgentSuggestOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_suggest_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('chalan_id')->after('order_id')->nullable();

            $table->foreign('chalan_id')->references('id')->on('chalans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_suggest_orders', function (Blueprint $table) {
            $table->dropForeign(['chalan_id']);
            $table->dropColumn('chalan_id');
        });
    }
}
