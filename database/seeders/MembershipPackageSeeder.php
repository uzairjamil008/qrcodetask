<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipPackageSeeder extends Seeder
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
            [
                'title' => 'Silver Package (Sell Anything)',
                'price' => '0',
                'location' => 'WORLD WIDE',
                'commission_per_sale' => '2.5%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Standard Package (Accept Bookings & Reservations Or RSVPS)',
                'price' => '0',
                'location' => 'WORLD WIDE',
                'commission_per_sale' => '0%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('membership_packages')->insert($data);

    }
}
