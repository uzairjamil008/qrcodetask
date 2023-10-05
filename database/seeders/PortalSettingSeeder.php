<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('portal_settings')->insert([
            'name' => $faker->company,
            'address' => $faker->address,
            'phone' => $faker->phoneNumber,
            'logo' => '\storage\portalsetting\logo' . $faker->image(public_path('/storage/portalsetting/logo'), 100, 100, null, false, true, uniqid()),
            'email' => $faker->unique()->safeEmail,
        ]);
    }
}
