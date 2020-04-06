<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('add_by')->nullable();
            $table->unsignedInteger('match_id')->nullable();
            $table->string('name');
            $table->string('source_share', 50)->nullable();
            $table->string('type', 100);
            $table->string('type_request', 100);
            $table->float('price')->default(0);
            $table->float('discount')->default(0);
            $table->string('link');
            $table->string('checkoutId')->nullable();
            $table->string('transactionId')->nullable();
            $table->string('code')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_bill')->default(0);
            $table->tinyInteger('is_share')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('add_by')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            //$table->unique(['link']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders');
    }

}
