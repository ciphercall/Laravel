<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('route')->default('#');
            $table->string('icon')->default('fa fa-list');
            $table->boolean('is_new_panel')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
        });

        Schema::create('menu_permission',function(Blueprint $table){
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('permission_id');

            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_permission');
        Schema::dropIfExists('menus');
    }
}
