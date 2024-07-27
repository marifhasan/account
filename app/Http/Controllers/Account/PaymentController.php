<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Asset;
use App\Models\Payment;
use App\Models\PaymentSector;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PaymentController extends Controller
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
     * Show the Payment list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'payments' => Payment::latest()->get(),
        ];

        return Inertia::render('Account/Payment/Index', $params);
    }

    /**
     * Show the Payment create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [
            'assets' => Asset::all(),
            'sectors' => PaymentSector::all(),
            'accounts' => Account::all(),
        ];

        return Inertia::render('Account/Payment/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Payment  $payment
     * @return Response
     */
    public function store(Request $request)
    {
        $asset_status = $request->payment_type == 'asset' ? 'required' : 'nullable';
        $sector_status = $request->payment_type == 'sector' ? 'required' : 'nullable';

        $request->validate([
            'sector.id' => [$sector_status],
            'asset.id' => [$asset_status, 'exists:assets,id'],
            'account.id' => ['required', 'exists:accounts,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        $payment = new Payment;
        $payment->date = Carbon::parse($request->date);
        $payment->amount = $request->amount;
        $payment->discount = $request->discount;
        $payment->total = $request->total;
        $payment->account_id = $request->account['id'];

        if ($request->payment == 'sector') {
            if (isset($request->sector['id'])) {
                $payment->sector_id = $request->sector['id'];
            } elseif (is_string($request->sector)) {
                $sector = PaymentSector::create([
                    'name' => $request->sector,
                ]);
                $payment->sector_id = $sector->id;
            }
        }
        if ($request->payment == 'asset') {
            $payment->asset_id = $request->asset['id'];
        }

        if (! $payment->save()) {
            DB::rollback();

            return back()->with('fail', 'Payment creating failed.');
        }

        $payment->remark = $request->remark;
        $payment->history = 'Payment Created';

        DB::commit();

        return back()->with('success', $payment->name.' Payment created successfully.');
    }

    /**
     * Show the Payment detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Payment $payment)
    {
        $params = [
            'payment' => $payment,
        ];

        return Inertia::render('Account/Payment/Show', $params);
    }

    /**
     * Show the Payment edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Payment $payment)
    {
        $params = [
            'payment' => $payment,
            'assets' => Asset::all(),
            'sectors' => PaymentSector::all(),
            'accounts' => Account::all(),
        ];

        return Inertia::render('Account/Payment/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Payment  $payment
     * @return Response
     */
    public function update(Request $request, Payment $payment)
    {
        $asset_status = $request->payment_type == 'asset' ? 'required' : 'nullable';
        $sector_status = $request->payment_type == 'sector' ? 'required' : 'nullable';
        $request->validate([
            'asset.id' => [$asset_status, 'exists:assets,id'],
            'sector.id' => [$sector_status, 'exists:sectors,id'],
            'account.id' => ['required', 'exists:accounts,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        $payment->date = Carbon::parse($request->date);
        $payment->asset_id = $request->payment == 'asset' ? $request->asset['id'] : null;
        $payment->sector_id = $request->payment == 'sector' ? $request->sector['id'] : null;
        $payment->account_id = $request->account['id'];
        $payment->amount = $request->amount;
        $payment->discount = $request->discount;
        $payment->total = $request->total;
        $payment->update();

        $payment->remark = $request->remark;
        $payment->history = 'Payment Updated';

        DB::commit();

        return back()->with('success', 'Payment updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Payment  $payment
     * @return Response
     */
    public function destroy(Payment $payment)
    {
        DB::beginTransaction();
        $payment->delete();

        $payment->history = 'Payment Deleted';
        DB::commit();

        return redirect()->route('payment.index')->with('success', __('Payment removed successfully'));
    }

    /**
     * Change status the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Payment  $payment
     * @return Response
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        if (! array_key_exists($request->status, $payment->statuses)) {
            return back()->with('fail', 'Status changing request failed! Invalid status!');
        }

        DB::beginTransaction();

        $payment->status = $request->status;
        $payment->history = 'Status Changed to '.$payment->statuses[$request->status];

        DB::commit();

        return back()->with('success', 'Status changed to "'.$payment->statuses[$request->status].'" successfully');
    }
}
