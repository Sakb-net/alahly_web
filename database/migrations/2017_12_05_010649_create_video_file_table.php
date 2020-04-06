<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoFileTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('table_id')->nullable();
            $table->string('table_name', 50)->nullable();
            $table->string('name', 200);
            $table->string('video');
            $table->string('upload_id', 200)->nullable();
            $table->mediumText('image')->nullable();
            $table->mediumText('content')->nullable();
            $table->string('time', 100)->default('00:00');
            $table->string('link');
            $table->string('extension', 100)->nullable();
            $table->Integer('view_count')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            //$table->unique(['link']);
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('table_id')->nullable();
            $table->string('table_name', 50)->nullable();
            $table->string('name', 200);
            $table->string('file');
            $table->string('link');
            $table->Integer('view_count')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            //$table->unique(['link']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('videos');
        Schema::dropIfExists('files');
    }

}
