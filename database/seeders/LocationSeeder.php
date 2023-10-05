<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
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
            'location_country_name' => $faker->country,
        ];
        $locationCountryId = DB::table('location_countries')->insert($data);

        DB::table('location_cities')->insert([
            'location_city_name' => $faker->city,
            'location_city_zipcode' => $faker->postcode,
            'location_country_id' => $locationCountryId,
            'map' => $faker->url,
            'location_valid_flag' => $faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
