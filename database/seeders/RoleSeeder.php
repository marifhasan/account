<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'User' => 'User',
            'Admin' => 'Admin',
        ];

        foreach ($names as $short => $name) {
            DB::table('roles')->insert([
                'slug' => Str::slug($name),
                'short' => Str::lower($short),
                'name' => $name,
                'permissions_list' => null,
            ]);
        }
    }
}
