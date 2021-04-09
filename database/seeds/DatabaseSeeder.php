<?php

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
        // $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(CarrierSeeder::class);
        $this->call(CountrySeeder::class);
    }
}
