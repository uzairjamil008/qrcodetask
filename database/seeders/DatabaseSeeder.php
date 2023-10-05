<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AffiliateSeeder::class);
        $this->call(BusinessSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(BusinessReservationSeeder::class);
        $this->call(CareerSeeder::class);
        $this->call(ContactUsSeeder::class);
        $this->call(HomeSliderSeeder::class);
        $this->call(MembershipPackageSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(PortalSettingSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(VehicleSeeder::class);
    }
}
