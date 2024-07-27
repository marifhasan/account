<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AssetTypeController extends Controller
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
            'types' => AssetType::latest()->get(),
        ];

        return Inertia::render('System/AssetType/Index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $params = [];

        return Inertia::render('System/AssetType/Create', $params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
        ]);

        DB::beginTransaction();
        $type = new AssetType;
        $type->name = $request->name;
        $type->save();

        $type->history = 'Asset Type Created';

        DB::commit();

        return back()->with('success', __('Asset Type added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  AssetType  $type
     * @return Response
     */
    public function show(AssetType $type)
    {
        $params = [
            'type' => $type,
        ];

        return Inertia::render('System/AssetType/Show', $params);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AssetType  $type
     * @return Response
     */
    public function edit(AssetType $type)
    {
        $params = [
            'type' => $type,
        ];

        return Inertia::render('System/AssetType/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  AssetType  $type
     * @return Response
     */
    public function update(Request $request, AssetType $type)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
        ]);

        DB::beginTransaction();
        $type->name = $request->name;
        $type->update();

        $type->history = 'Asset Type Modified';

        DB::commit();

        return back()->with('success', __('Asset Type modified successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AssetType  $type
     * @return Response
     */
    public function destroy(AssetType $type)
    {
        DB::beginTransaction();
        $type->delete();

        $type->history = 'Asset Type Deleted';

        DB::commit();

        return redirect()->route('type.index')->with('success', __('Asset Type removed successfully'));
    }
}
