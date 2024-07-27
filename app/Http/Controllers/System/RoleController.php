<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RoleController extends Controller
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $params = [
            'roles' => Role::latest()->get(),
        ];

        return Inertia::render('System/Role/Index', $params);
    }

    public function permission(Role $role)
    {
        $params = [
            'role' => $role,
            'items' => config('permission'),
        ];
        // dd(json_encode(config('permission')));
        // $wow = isset($permissions[$name]) && isset($permissions[$name][$item]) && $permissions[$name][$item] == "on";
        return Inertia::render('System/Role/Permission', $params);
    }

    public function permissionUpdate(Request $request, Role $role)
    {
        dd($request->all());
        if (! count($request->permissions)) {
            return back()->with('success', __('Noting has changed'));
        }

        $request->validate([
            'permissions' => ['nullable'],
        ]);

        DB::beginTransaction();
        $role->permissions_list = json_encode($request->permissions);
        $role->update();

        $role->history = 'Permission modified';

        DB::commit();

        return back()->with('success', __('Permission modified successfully'));
    }
}
