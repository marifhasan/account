<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'company_name' => [
                'title' => 'Company Name',
                'value' => 'Office MS',
            ],
            'company_address' => [
                'title' => 'Company Address',
                'value' => 'Mirpur DOHS-Dhaka, Bangladesh',
            ],
            'pdf_document_margin_top' => [
                'title' => 'Pdf Document Margin Top (mm)',
                'value' => '20',
            ],
            'pdf_document_margin_bottom' => [
                'title' => 'Pdf Document Margin Bottom (mm)',
                'value' => '15',
            ],
            'letter_head_margin_top' => [
                'title' => 'Letter Head Margin Top (mm)',
                'value' => '20',
            ],
            'letter_head_margin_bottom' => [
                'title' => 'Letter Head Margin Bottom (mm)',
                'value' => '15',
            ],
        ];

        foreach ($settings as $name => $setting) {
            DB::table('settings')->insert([
                'name' => $name,
                'title' => $setting['title'],
                'value' => $setting['value'],
            ]);
        }
    }
}
