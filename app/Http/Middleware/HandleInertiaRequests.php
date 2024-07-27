<?php

namespace App\Http\Middleware;

use App\Helpers;
use App\Http\Resources\User as ResourcesUser;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'auth' => [
                'user' => $request->user() ? new ResourcesUser($request->user()) : null,
            ],
            'alertMessage' => [
                'fail' => fn () => $request->session()->get('fail'),
                'success' => fn () => $request->session()->get('success'),
            ],
            'default' => [
                'photo' => $request->user() ? ($request->user()?->image ?? asset('/img/photo.jpg')) : asset('/img/photo.jpg'),
                'dummy_image' => asset('/img/logo.jpg'),
            ],
            'navigation' => Helpers::navigation(),
        ]);
    }
}
