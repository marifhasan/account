<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
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

    public function update(Request $request)
    {
        dd($request->all());
        DB::beginTransaction();
        foreach ($request->testimonials as $item) {
            $testimonial = Testimonial::find($item['id']);

            if ($testimonial && $testimonial->value != $item['value']) {
                $testimonial->value = $item['value'];
                $testimonial->update();
            } else {
                $product = Product::find($request->product_id);
                $testimonial = new Testimonial(
                    [
                        'personality' => $request->personality,
                        'description' => $request->description,
                    ]
                );
                $product->testimonials()->save($testimonial);
            }
        }

        DB::commit();

        return back()->with('success', 'Testimonials updated successfully');
    }
}
