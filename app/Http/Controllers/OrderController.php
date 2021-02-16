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
        if (request()->session()->has('success')) {
            return inertia('Order/Index')->with('success', request()->session()->get('success'));
        }
         if (request()->session()->has('error')) {
            return inertia('Order/Index')->with('error', request()->session()->get('error'));
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
        $response = self::storeOrder($request->all());

        return redirect()->route('order.index')
            ->with('info','El proceso se realizo con exito');
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

        if ($order) {
            return redirect()->route('order.index')
            ->with('success','El pedido se actualizó con exito');    
        }
        return redirect()->route('order.index')
        ->with('error','Sucedió un error, no se pudo actualizar');    
        

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

    public function sendEmailUpdate($id)
    {
        return self::sendEmailUpdateTrait($id);
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
