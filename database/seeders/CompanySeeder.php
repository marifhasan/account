<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Company::truncate();

        DB::table('companies')->insert([
            'name' => 'Tuple',
            'href' => 'https://tailwindui.com/img/logos/tuple-logo-gray-400.svg',
        ]);
        DB::table('companies')->insert([
            'name' => 'Mirage',
            'href' => 'https://tailwindui.com/img/logos/mirage-logo-gray-400.svg',
        ]);
        DB::table('companies')->insert([
            'name' => 'StaticKit',
            'href' => 'https://tailwindui.com/img/logos/statickit-logo-gray-400.svg',
        ]);
        DB::table('companies')->insert([
            'name' => 'Transistor',
            'href' => 'https://tailwindui.com/img/logos/transistor-logo-gray-400.svg',
        ]);
        DB::table('companies')->insert([
            'name' => 'Workcation',
            'href' => 'https://tailwindui.com/img/logos/workcation-logo-gray-400.svg',
        ]);
    }
}
