<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('meta_type',50)->default('data');
            $table->mediumText('meta_value')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('display_name',100)->after('name');
            $table->string('phone',50)->unique()->after('email');
            $table->string('type')->default('member')->after('password');
            $table->string('image')->nullable()->after('type');
            $table->string('address',50)->nullable()->after('image');
            $table->string('city',50)->nullable()->after('address');
            $table->string('state',50)->nullable()->after('city');
            $table->string('access_token')->nullable()->after('state');
            $table->string('device_id')->nullable()->after('access_token');
            $table->string('fcm_token')->nullable()->after('device_id');
            $table->tinyInteger('state_fcm_token')->default(1)->after('fcm_token');
            $table->string('gender',50)->nullable()->after('state_fcm_token');
            $table->string('jop',100)->nullable()->after('gender');
            $table->string('reg_site',50)->nullable()->after('gender');
            $table->string('session',100)->nullable()->after('reg_site');
            $table->string('lang',50)->default('ar')->after('session');
            $table->tinyInteger('is_active')->default(0)->after('lang');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_meta');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('display_name');
            $table->dropColumn('phone');
            $table->dropColumn('image');
            $table->dropColumn('address');
            $table->dropColumn('is_active');
        });
    }
}
