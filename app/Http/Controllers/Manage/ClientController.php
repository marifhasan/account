<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClientController extends Controller
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
     * Show the clients list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'clients' => Client::latest()->get(),
        ];

        return Inertia::render('Manage/Client/Index', $params);
    }

    /**
     * Show the client create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [];

        return Inertia::render('Manage/Client/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Client  $client
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'short' => ['nullable', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:1000'],
            'contact_name' => ['nullable', 'string', 'max:191'],
            'contact_number' => ['nullable', 'string', 'max:191'],
        ]);

        DB::beginTransaction();
        $client = new Client;
        $client->name = $request->name;
        $client->short = $request->short;
        $client->contact_name = $request->contact_name;
        $client->contact_number = $request->contact_number;

        if (! $client->save()) {
            return back()->with('fail', 'Client creating failed.');
        }

        $client->address = $request->address;
        $client->remark = $request->remark;
        $client->history = 'Client Created';

        DB::commit();

        return redirect()->route('client.index')->with('success', 'Client created successfully.');
    }

    /**
     * Show the client detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Client $client)
    {
        $params = [
            'client' => $client,
        ];

        return Inertia::render('Manage/Client/Show', $params);
    }

    /**
     * Show the client edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Client $client)
    {
        $params = [
            'client' => $client,
        ];

        return Inertia::render('Manage/Client/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Client  $client
     * @return Response
     */
    public function update(Request $request, Client $client)
    {
        $opening_status = $request->opening_check ? 'required' : 'nullable';
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'short' => ['nullable', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'contact_name' => ['nullable', 'string', 'max:191'],
            'contact_number' => ['nullable', 'string', 'max:191'],
            'opening_balance' => [$opening_status, 'max:16'],
            'opening_date' => [$opening_status, 'string'],
        ]);

        DB::beginTransaction();
        $client->name = $request->name;
        $client->short = $request->short;
        $client->contact_name = $request->contact_name;
        $client->contact_number = $request->contact_number;
        $client->remark = $request->remark;

        if (! $client->update()) {
            return back()->with('fail', 'Client updating failed.');
        }

        $client->opening_balance = $request->opening_balance;
        $client->opening_date = $request->opening_date;

        $client->address = $request->address;
        $client->remark = $request->remark;
        $client->history = 'Client Modified';

        DB::commit();

        return back()->with('success', 'Client updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Client  $client
     * @return Response
     */
    public function destroy(Client $client)
    {
        DB::beginTransaction();
        $client->delete();

        $client->history = 'Client Deleted';
        DB::commit();

        return redirect()->route('client.index')->with('success', __('Client removed successfully'));
    }
}
