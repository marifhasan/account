<?php

namespace App\Http\Controllers\Manage;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company as ResourcesCompany;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CompanyController extends Controller
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
     * Show the companies list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $companies = Company::latest()->get();
        $params = [
            'companies' => ResourcesCompany::collection($companies),
        ];

        return Inertia::render('Manage/Company/Index', $params);
    }

    /**
     * Show the company create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [];

        return Inertia::render('Manage/Company/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Company  $company
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'href' => ['nullable', 'string', 'max:191'],
        ]);

        DB::beginTransaction();
        $company = new Company;
        $company->name = $request->name;
        $company->href = $request->href;
        $company->save();

        DB::commit();

        return redirect()->route('company.index')->with('success', 'Company created successfully.');
    }

    /**
     * Show the company detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Company $company)
    {
        $params = [
            'company' => new ResourcesCompany($company),
        ];

        return Inertia::render('Manage/Company/Show', $params);
    }

    /**
     * Show the company edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Company $company)
    {
        $params = [
            'company' => new ResourcesCompany($company),
        ];

        return Inertia::render('Manage/Company/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Company  $company
     * @return Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'href' => ['nullable', 'string', 'max:191'],
        ]);

        DB::beginTransaction();
        $company->name = $request->name;
        $company->href = $request->href;
        $company->update();

        Helpers::imageUpload($request, '-company-logo.', $company);
        DB::commit();

        return back()->with('success', 'Company updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Company  $company
     * @return Response
     */
    public function destroy(Company $company)
    {
        DB::beginTransaction();
        $company->delete();

        DB::commit();

        return redirect()->route('company.index')->with('success', __('Company removed successfully'));
    }
}
