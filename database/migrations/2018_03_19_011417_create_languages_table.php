<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('lang',50);
            $table->string('name',50);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
        });
        
//        Schema::create('relation_lang', function (Blueprint $table) {
//            $table->increments('id');
//            $table->unsignedInteger('ar_id');
//            $table->unsignedInteger('lang_id');
//            $table->string('lang',50);
//            $table->string('type', 100);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('languages');
//        Schema::dropIfExists('relation_lang');
    }

}
