<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'name' => 'Interpack',
            'short' => 'ip',
            'contact_name' => 'Atanu',
            'contact_number' => '',
        ]);
        DB::table('clients')->insert([
            'name' => '1.6 G',
            'short' => '1.6',
            'contact_name' => 'Safayet',
            'contact_number' => '',
        ]);
        DB::table('clients')->insert([
            'name' => 'Lantabur',
            'short' => 'lb',
            'contact_name' => 'Kaoser',
            'contact_number' => '',
        ]);
    }
}
