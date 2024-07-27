<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BillController extends Controller
{
    protected $vat_types = [
        ['id' => 'including', 'name' => 'Including'],
        ['id' => 'excluding', 'name' => 'Excluding'],
    ];

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
     * Show the Bill list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'bills' => Bill::latest()->get(),
        ];

        return Inertia::render('Account/Bill/Index', $params);
    }

    /**
     * Show the Bill create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [
            'clients' => Client::all(),
            'vat_types' => $this->vat_types,
        ];

        return Inertia::render('Account/Bill/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Bill  $bill
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client.id' => ['required', 'exists:clients,id'],
            'job.id' => ['required', 'exists:clients,id'],
            'date' => ['required', 'date'],
            'number' => ['required', 'string', 'max:191', 'unique:bills'],
            'description' => ['nullable', 'string', 'max:500'],
            'amount' => ['required', 'numeric'],
            'vat' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();
        $bill = new Bill;
        $bill->number = $request->number;
        $bill->amount = $request->amount;
        $bill->vat = $request->vat;
        $bill->total = $request->total;
        $bill->date = Carbon::parse($request->date);
        $bill->job_id = $request->job['id'];
        $bill->client_id = $request->client['id'];
        $bill->save();

        $bill->remark = $request->remark;
        $bill->history = 'Bill Created';

        DB::commit();

        return back()->with('success', $bill->job->name.' of '.$bill->client->name.'\'s Bill created successfully.');
    }

    /**
     * Show the Bill detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Bill $bill)
    {
        $params = [
            'bill' => $bill,
        ];

        return Inertia::render('Account/Bill/Show', $params);
    }

    /**
     * Show the Bill edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Bill $bill)
    {
        $params = [
            'bill' => $bill,
            'clients' => Client::all(),
            'vat_types' => $this->vat_types,
        ];

        return Inertia::render('Account/Bill/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Bill  $bill
     * @return Response
     */
    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'client.id' => ['required', 'exists:clients,id'],
            'job.id' => ['required', 'exists:clients,id'],
            'date' => ['required', 'date'],
            'number' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'amount' => ['required', 'numeric'],
            'vat' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();
        $bill->number = $request->number;
        $bill->amount = $request->amount;
        $bill->vat = $request->vat;
        $bill->total = $request->total;
        $bill->date = Carbon::parse($request->date);
        $bill->job_id = $request->job['id'];
        $bill->client_id = $request->client['id'];
        $bill->update();

        $bill->remark = $request->remark;
        $bill->history = 'Bill Modified';

        DB::commit();
        $request->flash();

        return back()->withInput()->with('success', 'Bill updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Bill  $bill
     * @return Response
     */
    public function destroy(Bill $bill)
    {
        DB::beginTransaction();
        $bill->delete();

        $bill->history = 'Bill Deleted';
        DB::commit();

        return redirect()->route('bill.index')->with('success', __('Bill removed successfully'));
    }

    /**
     * Change status the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Bill  $bill
     * @return Response
     */
    public function updateStatus(Request $request, Bill $bill)
    {
        if (! array_key_exists($request->status, $bill->statuses)) {
            return back()->with('fail', 'Status changing request failed! Invalid status!');
        }

        DB::beginTransaction();

        $bill->status = $request->status;
        $bill->history = 'Status Changed to '.$bill->statuses[$request->status];

        DB::commit();

        return back()->with('success', 'Status changed to "'.$bill->statuses[$request->status].'" successfully');
    }
}
