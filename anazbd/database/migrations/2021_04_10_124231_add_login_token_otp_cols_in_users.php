<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginTokenOtpColsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('login_token')->nullable()->after('remember_token');
            $table->string('login_otp')->nullable()->after('login_token');
            $table->string('login_token_generated_at')->nullable()->after('login_token');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('login_token');
            $table->dropColumn('login_otp');
            $table->dropColumn('login_token_generated_at');
        });
    }
}
