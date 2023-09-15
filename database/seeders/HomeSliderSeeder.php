<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeSliderSeeder extends Seeder
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
            'heading' => $faker->sentence,
            'sub_heading' => $faker->sentence,
            'type' => $faker->word,
            'button_text' => $faker->word,
            'file' => '\storage\homeslide\file' . $faker->image(public_path('/storage/homeslide/file'), 100, 100, null, false, true, uniqid()),

        ];
        DB::table('home_sliders')->insert($data);
    }
}
