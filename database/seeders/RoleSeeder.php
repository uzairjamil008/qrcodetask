<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'role_title' => 'Admin',
            ],
            [
                'role_title' => 'User',
            ],
            [
                'role_title' => 'Business',
            ],
            [
                'role_title' => 'Affiliate',
            ],
            [
                'role_title' => 'Customer',
            ],
        ];
        DB::table('roles')->insert($data);
    }
}
