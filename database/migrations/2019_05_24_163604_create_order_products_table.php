<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('order_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('add_by')->nullable();
            $table->string('source_share', 50)->nullable();
            $table->string('type', 100);
            $table->string('type_request', 100);
            $table->float('total_price')->default(0);
            $table->float('total_discount')->default(0);
            $table->string('fees', 200);
            $table->float('fees_price')->default(0);
            $table->string('link');
            $table->string('checkoutId')->nullable();
            $table->string('transactionId')->nullable();
            $table->string('code')->nullable();
            $table->string('state_stoke', 200)->nullable();
            $table->tinyInteger('is_recieved')->default(0);
            $table->tinyInteger('is_delivery')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_bill')->default(1);
            $table->tinyInteger('is_stoke')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('add_by')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            //$table->unique(['link']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('order_products');
    }

}
