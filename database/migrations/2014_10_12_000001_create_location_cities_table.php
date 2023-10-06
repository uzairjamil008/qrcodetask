<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_cities', function (Blueprint $table) {
            $table->id();
            $table->string('location_city_name')->nullable();
            $table->string('location_city_zipcode')->nullable();
            $table->foreignId('location_country_id')->references('id')->on('location_countries')->constrained()->onDelete('cascade');
            $table->string('map')->nullable();
            $table->string('location_valid_flag')->nullable();
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
        Schema::table('location_cities', function (Blueprint $table) {
            $table->dropForeign(['location_country_id']);
            $table->drop();
        });
    }
}
