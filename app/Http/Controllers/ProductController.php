<?php

namespace App\Http\Controllers;

use App\Models\UnitMeasure;
use App\Models\Product;
use App\Traits\MultimediaTrait;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ProductTrait,
        MultimediaTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        
        return inertia('Product/Index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Product/Create', [
            'units_measure' => UnitMeasure::where('available',1)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100|unique:products',
            'reference' => 'nullable|string|max:50',
            'unit_measure_id' => 'required|numeric|gt:0',
            'price' => 'nullable|numeric|min:0',
        ]);

        $product = self::storeProduct($request->all());

        if (!$request->filled('photos')) {

            self::storeMultimedia($request->file('photos'), 'products', 'product', 'img_product','product_id', $product->id);
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return inertia('Product/Show', [
            'product' => Product::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        
        return inertia('Product/Edit', ['units_measure' => UnitMeasure::where('available',1)->get(), 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $product->update($request->all());
        return \Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
