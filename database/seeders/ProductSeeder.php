<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $businessId = DB::table('users')->where('role_id', '1')->pluck('id')->first();

        $data = [
            'business_id' => $businessId,
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'product_dp' => '\storage\product\productdp' . $faker->image(public_path('/storage/product/productdp'), 100, 100, null, false, true, uniqid()),
            'price' => $faker->randomFloat(2, 10, 100),
            'fee' => $faker->randomFloat(2, 1, 10),
            'total_tickets' => $faker->numberBetween(1, 100),
            'ticket_available' => $faker->numberBetween(0, 100),
            'is_return' => $faker->boolean,
            'refundable' => $faker->randomElement(['Yes', 'No'])];
        DB::table('products')->insert($data);
    }
}
