<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        DB::table('products')->insert([
            'name' => 'Apparels Production, Export',
            'icon' => 'InboxIcon',
            'href' => 'https://pacificmoonllc.com/',
            'intro' => 'Get a better understanding of where your traffic is coming from.',
            'company_id' => 1,
            'branding' => 1,
            'description' => 'Semper curabitur ullamcorper posuere nunc sed. Ornare iaculis bibendum malesuada faucibus lacinia porttitor. Pulvinar laoreet sagittis viverra duis. In venenatis sem arcu pretium pharetra at. Lectus viverra dui tellus ornare pharetra.',
        ]);
        $product = Product::find(1);
        $testimonial = new Testimonial(
            [
                'personality' => 'Marcia Hill, Digital Marketing Manager',
                'description' => 'Cras velit quis eros eget rhoncus lacus ultrices sed diam. Sit orci risus aenean curabitur donec aliquet. Mi venenatis in euismod ut.',
            ]
        );
        $product->testimonials()->save($testimonial);

        DB::table('products')->insert([
            'name' => 'Construction Accounts',
            'icon' => 'AnnotationIcon',
            'href' => 'http://acc.hexagonep.com/',
            'intro' => 'Speak directly to your customers in a more meaningful way.',
            'company_id' => 2,
            'branding' => 2,
            'description' => 'Semper curabitur ullamcorper posuere nunc sed. Ornare iaculis bibendum malesuada faucibus lacinia porttitor. Pulvinar laoreet sagittis viverra duis. In venenatis sem arcu pretium pharetra at. Lectus viverra dui tellus ornare pharetra.',
        ]);
        DB::table('products')->insert([
            'name' => 'Packaging & Printing Company',
            'icon' => 'ChatAlt2Icon',
            'href' => 'http://104.219.248.153/',
            'intro' => "Your customers' data will be safe and secure.",
            'company_id' => 3,
        ]);
        DB::table('products')->insert([
            'name' => 'Restaurant',
            'icon' => 'QuestionMarkCircleIcon',
            'href' => 'https://app.meghdubi.com/',
            'intro' => "Connect with third-party tools that you're already using.",
            'company_id' => 4,
        ]);
    }
}
