<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Traits\OrderTrait;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use OrderTrait;
    use ProductTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'products' => self::getAllProductsToOrder(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $response = self::storeOrder($request->all());

        return $response ? redirect()->route('order.index')->with('success','El pedido se guardó con éxito')
                : redirect()->back()->with('error','Sucedió un error, no se pudo crear el pedido');
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

        if ($order->status == 'activo') {
            return inertia('Order/Edit', [
                'order' => $order,
                'products' => self::getAllProductsToOrder(),
                'contract_old' => self::getMultimediaByParams('order','order_id',$id,'contract_file'),
                'purchase_order_old' => self::getMultimediaByParams('order','order_id',$id,'purchase_order_file'),
            ]);
        }
        
        return redirect()->back()->with('info','No se puede editar debido a que se canceló o esta finalizado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, $id)
    {
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
