<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_comments', function (Blueprint $table) {
           $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('blog_id')->nullable();
            $table->unsignedInteger('parent_one_id')->nullable();
            $table->unsignedInteger('parent_two_id')->nullable();
//            $table->ipAddress('visitor')->nullable();
            $table->string('type', 100)->nullable();
            $table->string('user_image');
            $table->string('name');
            $table->string('email');
            $table->text('content');
            $table->string('link', 200)->nullable();
//            $table->integer('update_id')->default(0);
            $table->text('image')->nullable();
            $table->text('video')->nullable();
            $table->text('audio')->nullable();
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_active')->default(1);
//            $table->morphs('commentable');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('blog_id')->references('id')->on('blogs')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_one_id')->references('id')->on('blog_comments')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_two_id')->references('id')->on('blog_comments')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_comments');
    }
}
