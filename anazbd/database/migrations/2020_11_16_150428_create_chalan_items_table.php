<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChalanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chalan_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chalan_id');
            $table->unsignedBigInteger('item_id');
            $table->string('price');
            $table->integer('qty');
            $table->string('subtotal');
            $table->timestamps();

            $table->foreign('chalan_id')->references('id')->on('chalans')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chalan_items');
    }
}
