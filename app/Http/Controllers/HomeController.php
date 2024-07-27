<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product as ResourcesProduct;
use App\Models\Company;
use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $solutions = Product::all();

        // https://en.wikipedia.org/wiki/Systems_development_life_cycle
        $features = [
            [
                'icon' => 'InboxIcon',
                'name' => 'Preliminary analysis',
                'description' => 'Begin with a preliminary analysis, propose alternative solutions, describe costs and benefits, and submit a preliminary plan with recommendations.',
            ],

            [
                'icon' => 'UsersIcon',
                'name' => 'Systems analysis, requirements definition',
                'description' => 'Define project goals into defined functions and operations of the intended application.',
            ],
            [
                'icon' => 'TrashIcon',
                'name' => 'Systems design',
                'description' => 'At this step, desired features and operations are described in detail, including screen layouts, business rules, process diagrams, pseudocode, and other documentation.',
            ],
            [
                'icon' => 'PencilAltIcon',
                'name' => 'Development',
                'description' => 'The real code is written here.',
            ],
            [
                'icon' => 'DocumentReportIcon',
                'name' => 'Integration and testing',
                'description' => 'All the modules are brought together into a special testing environment, then checked for errors, bugs, and interoperability.',
            ],
            [
                'icon' => 'ReplyIcon',
                'name' => 'Acceptance, installation, deployment',
                'description' => 'This is the final stage of initial development, where the software is put into production and runs actual business.',
            ],
            [
                'icon' => 'ChatAltIcon',
                'name' => 'Maintenance',
                'description' => 'During the maintenance stage of the SDLC, the system is assessed/evaluated to ensure it does not become obsolete. This is also where changes are made to initial software.',
            ],
            [
                'icon' => 'HeartIcon',
                'name' => 'Evaluation',
                'description' => 'This is where the system that was developed, as well as the entire process, is evaluated.',
            ],
        ];

        $metrics = [
            [
                'id' => 1,
                'stat' => '8K+',
                'emphasis' => 'Companies',
                'rest' => 'use laoreet amet lacus nibh integer quis.',
            ],
            [
                'id' => 2,
                'stat' => '25K+',
                'emphasis' => 'Countries around the globe',
                'rest' => 'lacus nibh integer quis.',
            ],
            [
                'id' => 3,
                'stat' => '98%',
                'emphasis' => 'Customer satisfaction',
                'rest' => 'laoreet amet lacus nibh integer quis.',
            ],
            [
                'id' => 4,
                'stat' => '12M+',
                'emphasis' => 'Issues resolved',
                'rest' => 'lacus nibh integer quis.',
            ],
        ];
        $companies = Company::all();

        $branding_products = Product::where('branding', '>', 0)->get();
        $branding_01 = count($branding_products) > 0 ? new ResourcesProduct($branding_products[0]) : null;
        $branding_02 = count($branding_products) > 1 ? new ResourcesProduct($branding_products[1]) : null;

        return Inertia::render('Home', [
            'branding_01' => $branding_01,
            'branding_02' => $branding_02,
            'metrics' => $metrics,
            'features' => $features,
            'companies' => $companies,
            'solutions' => $solutions,
        ]);

        // return Inertia::render('Welcome', [
        //     'canLogin'          => Route::has('login'),
        //     'canRegister'       => Route::has('register'),
        //     'laravelVersion'    => Application::VERSION,
        //     'phpVersion'        => PHP_VERSION,
        // ]);
    }

    // public function language()
    // {
    //     if (session()->has('language') && session('language') == 'bn') {
    //         session(['language' => "en"]);
    //     } else {
    //         session(['language' => "bn"]);
    //     }
    //     return back();
    // }
}
