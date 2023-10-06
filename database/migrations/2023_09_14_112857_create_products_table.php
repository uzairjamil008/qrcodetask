<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('product_dp')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('fee')->nullable();
            $table->string('total_tickets')->nullable();
            $table->string('ticket_available')->nullable();
            $table->boolean('is_return')->nullable();
            $table->string('refundable')->nullable();
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->drop();
        });
    }
}
