<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('type', 100);
            $table->mediumText('image')->nullable();
            $table->Text('content')->nullable();
            $table->string('link');
            $table->Integer('view_count')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('albums')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['link']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('albums');
    }

}
