<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AssetController extends Controller
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
     * Show the assets list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'assets' => Asset::latest()->get(),
        ];

        return Inertia::render('Manage/Asset/Index', $params);
    }

    /**
     * Show the asset create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [
            'types' => AssetType::all(),
        ];

        return Inertia::render('Manage/Asset/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Asset  $asset
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'type' => ['required', 'exists:types,id'],
            'value' => ['nullable', 'string', 'max:191'],
            'is_fixed' => ['nullable'],
            'address' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::beginTransaction();
        $asset = new Asset;
        $asset->name = $request->name;
        $asset->is_fixed = $request->is_fixed ? true : false;
        $asset->value = $request->value ?? 0;
        $asset->type_id = $request->type;
        $asset->save();

        $asset->history = 'Asset Created';

        $asset->address = $request->address;
        $asset->remark = $request->remark;

        DB::commit();

        return back()->with('success', $asset->name.' Asset created successfully.');
    }

    /**
     * Show the asset detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Asset $asset)
    {
        $params = [
            'asset' => $asset,
        ];

        return Inertia::render('Manage/Asset/Show', $params);
    }

    /**
     * Show the asset edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Asset $asset)
    {
        $params = [
            'asset' => $asset,
            'types' => AssetType::all(),
        ];

        return Inertia::render('Manage/Asset/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Asset  $asset
     * @return Response
     */
    public function update(Request $request, Asset $asset)
    {
        $opening_status = $request->opening_check ? 'required' : 'nullable';
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'type' => ['required', 'exists:types,id'],
            'value' => ['nullable', 'string', 'max:191'],
            'is_fixed' => ['nullable'],
            'address' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'opening_balance' => [$opening_status, 'max:16'],
            'opening_date' => [$opening_status, 'string'],
        ]);

        DB::beginTransaction();
        $asset->name = $request->name;
        $asset->is_fixed = $request->is_fixed ? true : false;
        $asset->value = $request->value ?? 0;
        $asset->type_id = $request->type;
        $asset->update();

        $asset->opening_balance = $request->opening_balance;
        $asset->opening_date = $request->opening_date;

        $asset->address = $request->address;
        $asset->remark = $request->remark;
        $asset->history = 'Asset Updated';

        DB::commit();

        return back()->with('success', 'Asset updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Asset  $asset
     * @return Response
     */
    public function destroy(Asset $asset)
    {
        DB::beginTransaction();
        $asset->delete();

        $asset->history = 'Asset Deleted';
        DB::commit();

        return redirect()->route('asset.index')->with('success', __('Asset removed successfully'));
    }
}
