<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Factory::create();
        $data = [
            'position_name' => 'Silver Package (Sell Anything)',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $careerPositionId = DB::table('career_positions')->insertGetId($data);

        $careerId = DB::table('careers')->insertGetId([
            'title' => $faker->jobTitle,
            'career_position_id' => $careerPositionId,
            'apply_last_date' => $faker->date(),
            'salary' => $faker->numberBetween(30000, 100000),
            'country' => $faker->country,
            'city' => $faker->city,
            'education' => $faker->word,
            'total_position' => $faker->numberBetween(1, 10),
            'description' => $faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // DB::table('careers')->insert([
        //     'career_position_id' => $careerId,
        //     'first_name' => $faker->firstName,
        //     'last_name' => $faker->lastName,
        //     'email' => $faker->unique()->safeEmail,
        //     'phone' => $faker->phoneNumber,
        //     'cv_file' => '\storage\career\cv' . $faker->image(public_path('/storage/career/cv'), 100, 100, null, false, true, uniqid()),
        //     'objective' => $faker->text(100),
        //     'status' => $faker->randomElement(['active', 'inactive']),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

    }
}
