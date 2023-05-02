<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelfOrderImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_order_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('self_order_id');
            $table->text('image');
            $table->timestamps();

            $table->foreign('self_order_id')->references('id')->on('self_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_order_images');
    }
}
