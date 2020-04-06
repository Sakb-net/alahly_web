<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
            $table->Integer('search_count')->default(1);
            $table->Integer('login_count')->default(0);
            $table->Integer('guest_count')->default(0);
            $table->tinyInteger('is_active')->default(1);
        });
        
        Schema::create('user_search', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('search_id');
            $table->Integer('user_id')->default(0);
            $table->ipAddress('visitor');
            $table->string('country_name')->nullable();
            $table->string('region_name')->nullable();
            $table->string('city')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->Integer('result_count')->default(1);
            $table->timestamps();
            $table->foreign('search_id')->references('id')->on('searches')->onUpdate('cascade')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('searches');
        Schema::dropIfExists('user_search');
    }
}
