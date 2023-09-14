<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->constrained()->onDelete('cascade');
            $table->string('reservation_number')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->dateTime('date')->nullable();
            $table->dateTime('check_out_date')->nullable();
            $table->dateTime('return_date_time')->nullable();
            $table->time('time')->nullable();
            $table->time('return_time')->nullable();
            $table->string('remarks')->nullable();
            $table->string('people')->nullable();
            $table->string('total_ticket')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('fee')->default(0)->nullable();
            $table->decimal('total_price')->nullable();
            $table->decimal('discount_code')->nullable();
            $table->decimal('discount_amount')->default(0)->nullable();
            $table->decimal('discount_percentage')->nullable();
            $table->decimal('net_amount')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('order_number')->nullable();
            $table->string('qr_code')->nullable();
            $table->longText('business_remarks')->nullable();
            $table->decimal('customer_spent')->nullable();
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
        Schema::table('business_reservations', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['product_id']);
            $table->drop();
        });
    }
}
