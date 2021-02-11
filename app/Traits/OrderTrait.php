<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\User;
use App\Traits\MultimediaTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
trait OrderTrait
{
	use MultimediaTrait;
	/*
	 * Valida el rol del usuario para retornar todas o solo las ordenes del usuario logueado
	 */
	public static function getOrdersByRole(){

		$isAdmin = Auth::user()->isAdmin();
		$orders = [];

		$orders = Order::where('user_id', Auth::id())->get();

		if ($isAdmin) {
			$orders = Order::with([
				'client',
				'creator'
			])->paginate(request()->get('lenght'));
		}

		return $orders;
	}

	public static function storeOrder($data){
		
		return DB::transaction(function () use ($data ) {

            $date = Carbon::now('America/Bogota');

            $order_id = DB::table('orders')->insertGetId([
            	'user_id' => $data['user_id'],
                'shipping_address' => $data['shipping_address'],
                'city' => $data['city'],
                'note' => $data['note'],
                'status' => 'activo',
                'total' => self::getTotalOrder($data['order_details']),
                'created_by' => Auth::user()->id,
                'created_at' => $date,
                'updated_at' => $date
            ]);
            if (request()->has('consignment')) {
            	$consignment_id = DB::table('consignments')->insertGetId([
            		'consignment_number' => $data['consignment']['consignment_number'],
            		'pse_url' => $data['consignment']['pse_url'],
            		'pse_number' => $data['consignment']['pse_number'],
            		'order_id' => $order_id,
            		'created_at' => Carbon::now('America/Bogota'),
            		'updated_at' => Carbon::now('America/Bogota'),
            	]);

            	if(request()->file('consignment')) {
            		self::storeSingleFileMultimedia(
            			request()->file('consignment')['imagen'], 
		                'consignments', 
		                'consignment', 
		                'consignment', 
		                'consignment_id', 
		                $consignment_id
            		);
            	}
            }

            foreach ($data['order_details'] as $value) {
                DB::table('order_details')->insert([
                    'order_id' => $order_id,
                    'product_id' => $value['product_id'],
                    'quantity' => $value['quantity'],
                    'discount' => $value['discount'],
                    'status' => 1,
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }
        });
	}

	public static function getTotalOrder($data)
	{
		$total = 0;

		foreach ($data as $key => $value) {
			$total += ($value['price'] * $value['quantity']) - $value['discount'];
		}

		return $total;
	}

	public static function getOrderByConsecutiveOrClientTrait()
	{
		return DB::table('orders')
		->join('users','orders.user_id','users.id')
		->where('orders.status','activo')
		->where('orders.id',request()->get('q'))
		->orWhere('users.name','like','%'. request()->get('q') .'%')
		->where('orders.status','activo')
		->select('orders.id as id','users.name as name')
		->get();

	}

	public static function findOrder($id)
	{
		$order = Order::where('id',$id)
		->with([
			'orderDetails.product',
			'client',
			'creator'
		])
		->first();

		return $order;
	}

	public static function updateOrder($data, $id)
	{
		$order = Order::find($id);
		if ($data->get('user_id')) {
			$order->update($data->all());
		}else{
			$user_id = $order->user_id;
			$order->fill($data->all());
			$order->user_id = $user_id;
			$order->save();
		}

		foreach ($data->order_details as $key => $value) {
			DB::table('order_details')
		    ->updateOrInsert(
		        [
		        	'order_id' => $id, 
		        	'product_id' => $value['product_id']
		        ],
		        [
		        	'quantity' => $value['quantity'],
		        	'discount' => $value['discount']
		        ]
		    );
		}
		return $order;
	}
}
