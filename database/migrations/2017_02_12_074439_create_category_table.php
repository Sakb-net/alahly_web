<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('link');
            $table->string('type', 50);
            $table->integer('parent_id')->default(0);
            $table->integer('order_id')->default(1);
            $table->Text('content')->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('icon')->nullable();
            $table->mediumText('icon_image')->nullable();
            $table->unsignedInteger('lang_id')->nullable();
            $table->string('lang', 50)->default('ar');
            $table->string('type_state', 50)->nullable();
            $table->integer('update_by')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['link', 'type']);
        });

//        Schema::create('category_meta', function (Blueprint $table) {
//            $table->increments('id');
//            $table->unsignedInteger('category_id');
//            $table->string('meta_type');
//            $table->string('meta_key')->nullable();
//            $table->mediumText('meta_value')->nullable();
//            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('categories');
//        Schema::dropIfExists('category_meta');
    }

}
