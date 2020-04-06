<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToBlogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('blogs', function (Blueprint $table) {
            $table->tinyInteger('is_delete')->default(0);
            $table->timestamp('date')->nullable();
            $table->string('time', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('is_delete');
            $table->dropColumn('date');
            $table->dropColumn('time');
        });
    }

}
