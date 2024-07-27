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
        // \App\Models\User::factory(10)->create();
        $this->call([

            RoleSeeder::class,
            // ExpenseSectorSeeder::class,
            // AssetTypeSeeder::class,

            AccountSeeder::class,
            // ClientSeeder::class,
            // AssetSeeder::class,
            UserSeeder::class,
            CompanySeeder::class,
            ProductSeeder::class,

            SettingSeeder::class,
        ]);
    }
}
