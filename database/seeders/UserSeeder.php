<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(): void
    {
        $faker = Factory::create();
        $userRoleId = DB::table('roles')->where('role_title', 'User')->pluck('id')->first();
        $livingCountry = DB::table('location_countries')->pluck('id')->first();
        $livingCity = DB::table('location_cities')->pluck('id')->first();

        $data = [
            'role_id' => $userRoleId,
            'affiliate_id' => $faker->uuid,
            'referral_code' => $faker->unique()->bothify('??###??'),
            'owner_name' => $faker->name,
            'name' => $faker->name,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'user_name' => $faker->userName,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'address' => $faker->address,
            'type' => $faker->word,
            'country' => $livingCountry,
            'site_link' => $faker->url,
            'details' => $faker->text,
            'map' => $faker->latitude . ',' . $faker->longitude,
            'discount' => $faker->randomFloat(2, 0, 100),
            'discount_code' => $faker->word,
            'postal_code' => $faker->postcode,
            'city' => $livingCity,
            'phone' => $faker->phoneNumber,
            'status' => $faker->word,
            'feature' => $faker->word,
            // 'dp' => '\storage\users\dp' . $faker->image(public_path('/storage/users/dp'), 100, 100, null, false, true, uniqid()),
            'personal_email' => $faker->safeEmail,
            'living_country' => $livingCountry,
            'living_city' => $livingCity,
            'existence_duration' => $faker->word,
            'cell_phone' => $faker->phoneNumber,
            'home_phone' => $faker->phoneNumber,
            'office_number' => $faker->phoneNumber,
            'image' => $faker->imageUrl(200, 200),
            'facebook' => 'https://www.facebook.com/user1',
            'twitter' => 'https://twitter.com/user1',
            'instagram' => 'https://www.instagram.com/user1',
            'linkedin' => 'https://www.linkedin.com/in/user1',
            // 'remember_token' => str_random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $userId = DB::table('users')->insertGetId($data);

        DB::table('user_videos')->insert([
            'user_id' => $userId,
            'video_url' => "https://www.youtube.com/watch?v",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sessions')->insert([
            'user_id' => $userId,
            'ip_address' => $faker->ipv4,
            'user_agent' => $faker->userAgent,
            'payload' => $faker->text(200),
            'last_activity' => $faker->numberBetween(1, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
