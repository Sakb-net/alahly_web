<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('setting_key')->nullable();
            $table->mediumText('setting_value')->nullable();
            $table->string('setting_etc')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('lang_id')->nullable();
            $table->string('lang',50)->default('ar');
            $table->Integer('view_count')->default(0);
            $table->timestamps();
            $table->foreign('lang_id')->references('id')->on('pages')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['lang_id', 'lang']);
        });

        Schema::create('page_content', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('page_id');
            $table->string('content_type');
            $table->string('content_key')->nullable();
            $table->mediumText('content_value')->nullable();
            $table->string('content_etc')->nullable();
            $table->string('content_other')->nullable();
//            $table->timestamp('created_at');
            $table->foreign('page_id')->references('id')->on('pages')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_content');
    }

}
