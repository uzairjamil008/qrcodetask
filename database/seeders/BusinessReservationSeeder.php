<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $productId = DB::table('products')->pluck('business_id')->first();
        $businessId = DB::table('users')->where('role_id', '1')->pluck('id')->first();
        $customerId = DB::table('users')->where('role_id', '1')->pluck('id')->first();
        $data = [
            'business_id' => $businessId,
            'customer_id' => $customerId,
            'product_id' => $productId,
            'reservation_number' => $faker->unique()->bothify('##??####'),
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'date' => $faker->dateTimeThisMonth(),
            'check_out_date' => $faker->dateTimeThisMonth(),
            'return_date_time' => $faker->dateTimeThisMonth(),
            'time' => $faker->time(),
            'return_time' => $faker->time(),
            'remarks' => $faker->text,
            'people' => $faker->numberBetween(1, 10),
            'total_ticket' => $faker->numberBetween(1, 5),
            'price' => $faker->randomFloat(2, 50, 200),
            'fee' => $faker->randomFloat(230, 350, 540),
            'total_price' => $faker->randomFloat(2, 50, 200),
            'discount_code' => $faker->word,
            'discount_amount' => $faker->randomFloat(2, 50, 200),
            'discount_percentage' => $faker->numberBetween(5, 20),
            'net_amount' => $faker->randomFloat(2, 40, 180),
            'status' => $faker->randomElement(['Pending', 'Confirmed', 'Completed', 'Canceled']),
            'type' => $faker->randomElement(['Reservation', 'Booking']),
            'order_number' => $faker->unique()->bothify('ORD###??'),
            'qr_code' => $faker->uuid,
            'business_remarks' => $faker->text,
            'customer_spent' => $faker->randomFloat(2, 10, 50),
            'created_at' => now(),
            'updated_at' => now()];
        DB::table('business_reservations')->insert($data);

    }
}
