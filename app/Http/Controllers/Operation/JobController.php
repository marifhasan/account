<?php

namespace App\Http\Controllers\Operation;

use App\Formula;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class JobController extends Controller
{
    protected $vat_types = [
        ['id' => 'including', 'name' => 'Including'],
        ['id' => 'excluding', 'name' => 'Excluding'],
    ];

    protected $service_types = [
        ['id' => 'software', 'name' => 'Software'],
        ['id' => 'maintenance', 'name' => 'Maintenance'],
        ['id' => 'server', 'name' => 'Server'],
    ];

    protected $bill_frequencies = [
        ['id' => 'monthly', 'name' => 'Monthly'],
        ['id' => 'yearly', 'name' => 'Yearly'],
        ['id' => 'quarterly', 'name' => 'Quarterly'],
        ['id' => 'manual', 'name' => 'Manual'],
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
     * Show the Job list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'jobs' => Job::latest()->get(),
        ];

        return Inertia::render('Operation/Job/Index', $params);
    }

    /**
     * Show the Job create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [
            'clients' => Client::all(),
            'vat_types' => $this->vat_types,
        ];

        return Inertia::render('Operation/Job/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Job  $job
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client' => ['required'],
            'name' => ['required', 'string', 'max:191'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:500'],
            'start_date' => ['required', 'date'],
            'expected_date' => ['nullable', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'vat_rate' => ['nullable', 'numeric'],
            'vat_type' => ['nullable', 'in:'.implode(',', array_column($this->vat_types, 'id'))],
        ]);

        DB::beginTransaction();
        $job = new Job;
        $job->name = $request->name;
        $job->number = Formula::nextJobSerial();
        $job->amount = $request->amount;
        $job->start_date = $request->start_date;
        $job->expected_date = $request->expected_date;
        $job->delivery_date = $request->delivery_date;
        $job->vat_rate = $request->vat_rate;
        $job->vat_type = $request->vat_type;

        if (isset($request->client['id'])) {
            $job->client_id = $request->client['id'];
        } elseif (is_string($request->client)) {
            $client = Client::create([
                'name' => $request->client,
            ]);
            $job->client_id = $client->id;
        }

        if (! $job->save()) {
            DB::rollback();

            return back()->with('fail', 'Job creating failed.');
        }

        $job->remark = $request->remark;

        $job->history = 'Job Created';

        DB::commit();

        return redirect()->route('job.index')->with('success', $job->name.' Job created successfully.');
    }

    /**
     * Show the Job detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Job $job)
    {
        $params = [
            'job' => $job,
        ];

        return Inertia::render('Operation/Job/Show', $params);
    }

    /**
     * Show the Job edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Job $job)
    {
        $params = [
            'job' => $job,
            'clients' => Client::all(),
            'vat_types' => $this->vat_types,
        ];

        return Inertia::render('Operation/Job/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Job  $job
     * @return Response
     */
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'client.id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:191'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:500'],
            'start_date' => ['required', 'date'],
            'expected_date' => ['nullable', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'vat_rate' => ['nullable', 'numeric'],
            'vat_type' => ['nullable', 'in:'.implode(',', array_column($this->vat_types, 'id'))],
        ]);

        DB::beginTransaction();
        $job->name = $request->name;
        $job->amount = $request->amount;
        $job->start_date = Carbon::parse($request->start_date);
        $job->expected_date = $request->expected_date ? Carbon::parse($request->expected_date) : null;
        $job->delivery_date = $request->delivery_date ? Carbon::parse($request->delivery_date) : null;
        $job->vat_rate = $request->vat_rate;
        $job->vat_type = $request->vat_type;
        $job->client_id = $request->client['id'];

        if (! $job->update()) {
            DB::rollback();

            return back()->with('fail', 'Job updating failed.');
        }

        $job->remark = $request->remark;
        $job->history = 'Job Modified';

        DB::commit();

        return back()->with('success', 'Job updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Job  $job
     * @return Response
     */
    public function destroy(Job $job)
    {
        $job->history = 'Job Deleted';

        if (! $job->delete()) {
            return back()->with('fail', 'Job removing failed.');
        }

        return redirect()->route('job.index')->with('success', __('Job removed successfully'));
    }

    /**
     * Change status the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Job  $job
     * @return Response
     */
    public function updateStatus(Request $request, Job $job)
    {
        if (! array_key_exists($request->status, $job->statuses)) {
            return back()->with('fail', 'Status changing request failed! Invalid status!');
        }

        $job->status = $request->status;
        $job->history = 'Status Changed to '.$job->statuses[$request->status];

        return back()->with('success', 'Status changed to "'.$job->statuses[$request->status].'" successfully');
    }
}
