<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Arif Hasan',
            'email' => 'arif.saiket@gmail.com',
            'password' => bcrypt('arif.saiket@gmail.com'),
            'is_admin' => 1,
            'created_at' => now(),
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Shourov Shahadat',
            'email' => 'shooorov@gmail.com',
            'password' => bcrypt('shooorov@gmail.com'),
            'is_admin' => 1,
            'created_at' => now(),
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Shourov Shahadat 01',
            'email' => 'shooorov1@gmail.com',
            'password' => bcrypt('shooorov1@gmail.com'),
            'is_admin' => 1,
            'created_at' => now(),
            'email_verified_at' => now(),
        ]);

        $image = new Image;
        $image->path = 'photos/bVKnjToGBB.jpg';
        $image->imageable_id = 2;
        $image->imageable_type = 'APP\Models\User';
        $image->save();
    }
}
