<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('order_detail_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('order_detail_id')->nullable();
            $table->string('name');
            $table->string('link');
            $table->string('type', 100);
            $table->float('quantity')->default(0);
            $table->float('price')->default(0);
            $table->float('discount')->default(0);
            $table->string('fees', 200)->nullable();
            $table->float('fees_price')->default(0);
            $table->mediumText('description')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_bill')->default(0);
            $table->tinyInteger('is_share')->default(1);
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('order_detail_id')->references('id')->on('order_products')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            //$table->unique(['link']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('order_detail_products');
    }

}
