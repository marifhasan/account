<?php

namespace App\Http\Controllers\Manage;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ResourceProduct;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends Controller
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
     * Show the products list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::latest()->get();
        $params = [
            'products' => count($products) ? ResourceProduct::collection($products) : [],
        ];

        return Inertia::render('Manage/Product/Index', $params);
    }

    /**
     * Show the product create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [
            'companies' => Company::all(),
        ];

        return Inertia::render('Manage/Product/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  Product  $product
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'href' => ['nullable', 'string', 'max:191'],
            'icon' => ['nullable', 'string', 'max:191'],
            'intro' => ['nullable', 'string', 'max:191'],
            'company_id' => ['required', 'exists:companies,id'],
            'description' => ['nullable', 'string', 'max:191'],
            'generic_name' => ['required', 'string', 'max:1000'],
        ]);

        DB::beginTransaction();
        $product = new Product;
        $product->name = $request->name;
        $product->href = $request->href;
        $product->icon = $request->icon;
        $product->intro = $request->intro;
        $product->company_id = $request->company_id;
        $product->description = $request->description;
        $product->generic_name = $request->generic_name;
        $product->save();

        DB::commit();

        return redirect()->route('product.edit', $product->id)->with('success', 'Product created successfully.');
    }

    /**
     * Show the product detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Product $product)
    {
        $params = [
            'product' => new ResourceProduct($product),
        ];

        return Inertia::render('Manage/Product/Show', $params);
    }

    /**
     * Show the product edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Product $product)
    {
        $params = [
            'product' => new ResourceProduct($product),
            'companies' => Company::all(),
        ];

        return Inertia::render('Manage/Product/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Product  $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'href' => ['nullable', 'string', 'max:191'],
            'icon' => ['nullable', 'string', 'max:191'],
            'intro' => ['nullable', 'string', 'max:191'],
            'branding' => ['required', 'numeric', 'max:191'],
            'company_id' => ['required', 'exists:companies,id'],
            'description' => ['nullable', 'string', 'max:191'],
            'generic_name' => ['required', 'string', 'max:1000'],
        ]);

        DB::beginTransaction();
        $product->name = $request->name;
        $product->href = $request->href;
        $product->icon = $request->icon;
        $product->intro = $request->intro;
        $product->branding = $request->branding;
        $product->company_id = $request->company_id;
        $product->description = $request->description;
        $product->generic_name = $request->generic_name;
        $product->update();

        Helpers::imageUpload($request, '-branding-image.', $product);

        DB::commit();

        return back()->with('success', 'Product updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  Product  $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        $product->delete();

        DB::commit();

        return redirect()->route('product.index')->with('success', __('Product removed successfully'));
    }
}
