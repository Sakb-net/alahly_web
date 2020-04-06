<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->integer('update_by')->default(0);
            $table->string('type', 50);
            $table->string('code', 250)->nullable();
            $table->string('name');
            $table->string('link');
            $table->mediumText('image')->nullable();
            $table->mediumText('content')->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('another_image', 50)->nullable();
            $table->mediumText('fees_id')->default(0);
            $table->float('price')->default(0);
            $table->float('discount')->default(0);
            $table->tinyInteger('order_id')->default(1);
            $table->Integer('number_prod')->default(0);
            $table->Integer('sale_number_prod')->default(0);
            $table->Integer('view_count')->default(0);
            $table->unsignedInteger('lang_id')->nullable();
            $table->string('lang', 50)->default('ar');
            $table->tinyInteger('comment_count')->default(0);
            $table->tinyInteger('is_share')->default(1);
            $table->tinyInteger('is_comment')->default(1);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('products')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lang_id')->references('id')->on('products')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            // $table->unique(['link','type']);
            $table->unique(['lang_id', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }

}
