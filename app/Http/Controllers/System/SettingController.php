<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SettingController extends Controller
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
     * Show the application settings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {
        $settings = Setting::all();
        $params = [
            'settings' => $settings,
        ];

        return Inertia::render('System/Setting', $params);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        foreach ($request->settings as $item) {
            $setting = Setting::find($item['id']);

            if ($setting->value != $item['value']) {
                $setting->value = $item['value'];
                $setting->update();

                $setting->history = "Setting '".$setting->title."' Modified";
            }
        }

        DB::commit();

        return back()->with('success', 'Settings updated successfully');
    }
}
