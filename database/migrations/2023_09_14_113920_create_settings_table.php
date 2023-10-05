<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('stage1_questions')->nullable();
            $table->string('stage2_questions')->nullable();
            $table->string('stage3_questions')->nullable();
            $table->float('method1_value')->nullable();
            $table->float('method2_value')->nullable();
            $table->float('threshold_value1')->nullable();
            $table->float('threshold_value2')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
