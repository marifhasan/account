<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\PaymentSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PaymentSectorController extends Controller
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
            'sectors' => PaymentSector::latest()->get(),
        ];

        return Inertia::render('System/PaymentSector/Index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $params = [];

        return Inertia::render('System/PaymentSector/Create', $params);
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
        $sector = new PaymentSector;
        $sector->name = $request->name;
        $sector->save();

        $sector->history = 'Payment Section Created';

        DB::commit();

        return back()->with('success', __('Sector added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Sector  $sector
     * @return Response
     */
    public function show(PaymentSector $sector)
    {
        $params = [
            'sector' => $sector,
        ];

        return Inertia::render('System/PaymentSector/Show', $params);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PaymentSector  $sector
     * @return Response
     */
    public function edit(PaymentSector $sector)
    {
        $params = [
            'sector' => $sector,
        ];

        return Inertia::render('System/PaymentSector/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  PaymentSector  $sector
     * @return Response
     */
    public function update(Request $request, PaymentSector $sector)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
        ]);

        DB::beginTransaction();
        $sector->name = $request->name;
        $sector->update();

        $sector->history = 'Payment Section Modified';

        DB::commit();

        return back()->with('success', __('Sector modified successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PaymentSector  $sector
     * @return Response
     */
    public function destroy(PaymentSector $sector)
    {
        DB::beginTransaction();
        $sector->delete();

        $sector->history = 'Payment Section Deleted';
        DB::commit();

        return redirect()->route('sector.index')->with('success', __('Sector removed successfully'));
    }
}
