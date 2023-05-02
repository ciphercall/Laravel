<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('description');
            $table->string('salary')->default('negotiable')->nullable();
            $table->string('experience')->default('N/A')->nullable();
            $table->string('min_qualification')->default('N/A')->nullable();
            $table->string('department')->default('N/A')->nullable();
            $table->string('gender')->default('N/A')->nullable();
            $table->string('location')->default('N/A')->nullable();
            $table->string('contact_email');
            $table->string('contact_mobile');
            $table->date("deadline");
            $table->boolean("status")->default(0);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
