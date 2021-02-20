<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use OrderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if (request()->session()->has('info')) {
    		return inertia('Order/Index')->with('info', request()->session()->get('info'));
    	}
        return inertia('Order/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return inertia('Order/Create', [
            'products' => Product::all(),
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
            'user_id' => 'required|numeric|min:1' ,
            'shipping_address' => 'required|string|max:100' ,
            'city' => 'required|string|max:100' ,
            'order_details' => 'required|array|min:1'
        ]);
        self::storeOrder($request->all());

        return redirect()->route('order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return inertia('Order/Show', [
            'order' => self::findOrder($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$order = self::findOrder($id);
    	if(count($order->consignments)){
    		return redirect()->route('order.index')->with('info','No es posible editar este pedido porque tiene consignaciones');
    	}
    	return inertia('Order/Edit', [
            'order' => $order,
            'products' => Product::all()
        ]);

       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric|min:1' ,
            'shipping_address' => 'required|string|max:100' ,
            'city' => 'required|string|max:100' ,
            'order_details' => 'required|array|min:1'
        ]);
        $order = self::updateOrder($request, $id);
        return redirect()->route('order.index');

    }

    public function updateStatusOrder($id)
    {
        return self::updateStatusOrderTrait($id);
    }

    public function cancel(Request $request, $id)
    {
        $this->validate($request,[
            'delete_note' => 'required|string|max:255'
        ]);
        
        return self::cancelOrder($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
