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
        $this->call(RolesTableSeeder::class);
        $this->call(UserProfileSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
    }
}