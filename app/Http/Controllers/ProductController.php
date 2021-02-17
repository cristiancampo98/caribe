<?php

namespace App\Http\Controllers;

use App\Models\UnitMeasure;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ProductTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Product/Index');
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
            'product' => self::getProductWithAllData($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return inertia('Product/Edit', [
            'units_measure' => UnitMeasure::where('available',1)->get(), 
            'product' => self::findProduct($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $response = self::updateProduct($id, $request);

       return $response ? redirect()->route('product.index')
                                    ->with('success','El producto se actualizó con éxito')
                : redirect()->back()->with('error','Sucedió un error, el producto no se actualizó');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function updateStatus($id)
    {
        return self::updateStatusProduct($id);
    }
}
