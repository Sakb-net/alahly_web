<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->ipAddress('visitor');
            $table->string('type',100)->nullable();
            $table->string('title',200)->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('content')->nullable();
            $table->mediumText('attachment')->nullable();
            $table->timestamp('created_at');
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_reply')->default(0);
        });
        
        Schema::create('contact_reply', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contact_id');
            $table->mediumText('title');
            $table->text('content');
            $table->mediumText('attachment')->nullable();
            $table->timestamp('created_at');
            $table->foreign('contact_id')->references('id')->on('contacts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('contact_reply');
    }
}
