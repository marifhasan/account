<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Client;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CollectionController extends Controller
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
     * Show the Collection list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'collections' => Collection::latest()->get(),
        ];

        return Inertia::render('Account/Collection/Index', $params);
    }

    /**
     * Show the Collection create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [
            'clients' => Client::all(),
            'accounts' => Account::all(),
        ];

        return Inertia::render('Account/Collection/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Collection  $collection
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'account.id' => ['required', 'exists:accounts,id'],
            'client.id' => ['required', 'exists:clients,id'],
            'amount' => ['nullable', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'total' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        $collection = new Collection;
        $collection->date = Carbon::parse($request->date);
        $collection->amount = $request->amount;
        $collection->discount = $request->discount;
        $collection->total = $request->total;
        $collection->account_id = $request->account['id'];
        $collection->client_id = $request->client['id'];
        $collection->save();

        $collection->remark = $request->remark;
        $collection->history = 'Collection Created';

        DB::commit();

        return back()->with('success', $collection->name.' Collection created successfully.');
    }

    /**
     * Show the Collection detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Collection $collection)
    {
        $params = [
            'collection' => $collection,
        ];

        return Inertia::render('Account/Collection/Show', $params);
    }

    /**
     * Show the Collection edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Collection $collection)
    {
        $params = [
            'collection' => $collection,
            'clients' => Client::all(),
        ];

        return Inertia::render('Account/Collection/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Collection  $collection
     * @return Response
     */
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'account.id' => ['required', 'exists:accounts,id'],
            'client.id' => ['required', 'exists:clients,id'],
            'amount' => ['nullable', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'total' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        $collection->date = Carbon::parse($request->date);
        $collection->amount = $request->amount;
        $collection->discount = $request->discount;
        $collection->total = $request->total;
        $collection->account_id = $request->account['id'];
        $collection->client_id = $request->client['id'];
        $collection->update();

        $collection->remark = $request->remark;
        $collection->history = 'Collection Modified';

        DB::commit();

        return back()->with('success', 'Collection updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Collection  $collection
     * @return Response
     */
    public function destroy(Collection $collection)
    {
        DB::beginTransaction();
        $collection->delete();

        $collection->history = 'Collection Deleted';
        DB::commit();

        return redirect()->route('collection.index')->with('success', __('Collection removed successfully'));
    }

    /**
     * Change status the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Collection  $collection
     * @return Response
     */
    public function updateStatus(Request $request, Collection $collection)
    {
        if (! array_key_exists($request->status, $collection->statuses)) {
            return back()->with('fail', 'Status changing request failed! Invalid status!');
        }

        DB::beginTransaction();

        $collection->status = $request->status;
        $collection->history = 'Status Changed to '.$collection->statuses[$request->status];

        DB::commit();

        return back()->with('success', 'Status changed to "'.$collection->statuses[$request->status].'" successfully');
    }
}
