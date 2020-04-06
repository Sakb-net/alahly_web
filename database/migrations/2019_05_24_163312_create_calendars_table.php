<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->integer('update_by')->default(0);
            $table->string('type', 50);
            $table->string('name');
            $table->string('link');
            $table->mediumText('image')->nullable();
            $table->mediumText('content')->nullable();
            $table->string('description')->nullable();
            $table->string('date')->nullable(); //dateTime
            $table->Integer('view_count')->default(0);
            $table->unsignedInteger('lang_id')->nullable();
            $table->string('lang', 50)->default('ar');
            $table->tinyInteger('is_delete')->default(0);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('calendars')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lang_id')->references('id')->on('calendars')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('calendars');
    }

}
