<?php

namespace App\Http\Controllers;

use App\Helpers;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'greeting' => Helpers::greeting(),
        ];

        return Inertia::render('Dashboard', $params);
    }
}
