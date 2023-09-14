<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->references('id')->on('roles')->constrained()->onDelete('cascade');
            $table->string('affiliate_id');
            $table->string('referral_code')->unique();
            $table->string('owner_name')->nullable();
            $table->string('name');
            $table->string('first_name');
            $table->string('lastname');
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('email_verified_at')->unique();
            $table->string('password')->nullable();
            $table->string('address');
            $table->foreignId('country')->references('id')->on('location_countries')->constrained()->onDelete('cascade');
            $table->string('site_link');
            $table->string('details');
            $table->string('map');
            $table->string('discount');
            $table->string('discount_code');
            $table->string('postal_code');
            $table->foreignId('city')->references('id')->on('location_cities')->constrained()->onDelete('cascade');
            $table->string('phone');
            $table->string('status');
            $table->string('feature');
            $table->string('dp');
            $table->string('personal_email');
            $table->string('living_country');
            $table->string('living_city');
            $table->string('existence_duration');
            $table->string('cell_phone');
            $table->string('home_phone');
            $table->string('office_number');
            $table->string('image');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->string('linkedin');
            $table->string('remember_token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['country']);
            $table->dropForeign(['city']);
            $table->drop();
        });
    }
}
