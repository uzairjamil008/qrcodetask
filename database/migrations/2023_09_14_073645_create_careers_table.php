<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('career_position_id')->references('id')->on('career_positions')->constrained()->onDelete('cascade');
            $table->string('apply_last_date')->nullable();
            $table->decimal('salary')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('education')->nullable();
            $table->string('total_position')->nullable();
            $table->string('description')->nullable();
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
        Schema::table('careers', function (Blueprint $table) {
            $table->dropForeign(['career_position_id']);
            $table->drop();
        });
    }
}
