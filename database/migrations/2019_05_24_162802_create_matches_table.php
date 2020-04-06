<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->integer('update_by')->default(0);
            $table->string('type', 50);
            $table->string('link');
            $table->string('name')->nullable();
            $table->string('first_team')->nullable();
            $table->string('second_team')->nullable();
            $table->Integer('first_goal')->default(0);
            $table->Integer('second_goal')->default(0);
            $table->timestamp('start_booking')->nullable();
            $table->timestamp('end_booking')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('time',100)->nullable();
            $table->mediumText('result')->nullable();
            $table->Text('first_image')->nullable();
            $table->Text('second_image')->nullable();
            $table->string('description')->nullable();
            $table->mediumText('content')->nullable();
            $table->unsignedInteger('video_id')->nullable();
            $table->unsignedInteger('file_id')->nullable();
            $table->unsignedInteger('lang_id')->nullable();
            $table->string('lang',50)->default('ar');
            $table->Integer('view_count')->default(0);
            $table->tinyInteger('is_comment')->default(1);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('matches')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('matches');
    }

}
