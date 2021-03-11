<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Traits\ProductTrait;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('haveaccess');

        return inertia('Product/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess');

        return inertia('Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
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
        Gate::authorize('haveaccess');

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
        Gate::authorize('haveaccess');

        return inertia('Product/Edit', [
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
       $this->validate($request,[

        'name' => 'required|string|max:100|unique:products,name,'.$id

       ]);
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
        Gate::authorize('haveaccess');   
    }

    public function updateStatus($id)
    {
        return self::updateStatusProduct($id);
    }
}
