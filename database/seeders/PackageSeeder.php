<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $data = [
            'name' => $faker->name,
            'details' => $faker->text(200),
            'price' => $faker->randomFloat(2, 10, 1000),
            'commission' => $faker->randomFloat(2, 1, 100),
            'location' => $faker->city,
        ];
        DB::table('packages')->insert($data);
    }
}
