<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AccountController extends Controller
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
     * Show the accounts list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'accounts' => Account::latest()->get(),
        ];

        return Inertia::render('Manage/Account/Index', $params);
    }

    /**
     * Show the account create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [
            'types' => [
                ['id' => 'bank', 'name' => 'Bank'],
                ['id' => 'loan', 'name' => 'Loan'],
            ],
        ];

        return Inertia::render('Manage/Account/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Account  $account
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'number' => ['required', 'string', 'max:191'],
            'branch' => ['nullable', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::beginTransaction();
        $account = new Account;
        $account->type = $request->type;
        $account->name = $request->name;
        $account->number = $request->number;
        $account->branch = $request->branch;
        $account->save();

        $account->address = $request->address;
        $account->remark = $request->remark;
        $account->history = 'Account Created';

        DB::commit();

        return back()->with('success', $account->name.' Account created successfully.');
    }

    /**
     * Show the account detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Account $account)
    {
        $params = [
            'account' => $account,
        ];

        return Inertia::render('Manage/Account/Show', $params);
    }

    /**
     * Show the account edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Account $account)
    {
        $params = [
            'account' => $account,
            'types' => [
                ['id' => 'bank', 'name' => 'Bank'],
                ['id' => 'loan', 'name' => 'Loan'],
            ],
        ];

        return Inertia::render('Manage/Account/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Account  $account
     * @return Response
     */
    public function update(Request $request, Account $account)
    {
        $opening_status = $request->opening_check ? 'required' : 'nullable';
        $request->validate([
            'type' => ['required', 'string', 'max:191'],
            'name' => ['nullable', 'string', 'max:191'],
            'number' => ['required', 'string', 'max:191'],
            'branch' => ['required', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:1000'],
            'opening_balance' => [$opening_status, 'max:16'],
            'opening_date' => [$opening_status, 'string'],
        ]);

        DB::beginTransaction();
        $account->type = $request->type;
        $account->name = $request->name;
        $account->number = $request->number;
        $account->branch = $request->branch;
        $account->update();

        $account->opening_balance = $request->opening_balance;
        $account->opening_date = $request->opening_date;

        $account->address = $request->address;
        $account->remark = $request->remark;
        $account->history = 'Account Modified';

        DB::commit();

        return back()->with('success', 'Account updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Account  $account
     * @return Response
     */
    public function destroy(Account $account)
    {
        DB::beginTransaction();
        $account->delete();

        $account->history = 'Account Deleted';
        DB::commit();

        return redirect()->route('account.index')->with('success', __('Account removed successfully'));
    }
}
