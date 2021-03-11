<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\User;
use App\Notifications\PaymentLink;
use App\Notifications\UpdatedOrder;
use App\Traits\ConsignmentTrait;
use App\Traits\MultimediaTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

/**
 * 
 */
trait OrderTrait
{
	use MultimediaTrait;
	use ConsignmentTrait;
	/*
	 * Valida el rol del usuario para retornar todas o solo las ordenes del usuario logueado
	 */
	public static function getOrdersByRole(){

		$isAdmin = Auth::user()->isAdmin();
		$orders = [];

		$orders = Order::with([
			'client',
			'creator',
			'consignments'
		])
		->where('user_id', Auth::id());

		if ($isAdmin) {
			$orders = Order::with([
				'client',
				'creator',
				'consignments'
			]);
		}

		return $orders->orderBy('id','desc')->paginate(request()->get('lenght'));
	}

	public static function storeOrder($data){
		
		return DB::transaction(function () use ($data ) {

            $date = Carbon::now('America/Bogota');

            $order_id = DB::table('orders')->insertGetId([
            	'user_id' => $data['user_id'],
                'shipping_address' => $data['shipping_address'],
                'department' => $data['department'],
                'city' => $data['city'],
                'note' => $data['note'],
                'status' => 'activo',
                'created_by' => Auth::user()->id,
                'created_at' => $date,
                'updated_at' => $date
            ]);

            if(request()->hasFile('contract')) {
        		self::storeSingleFileMultimedia(
        			request()->file('contract'), 
	                'documents_orders', 
	                'order', 
	                'contract_file', 
	                'order_id', 
	                $order_id
        		);
        	}
        	
        	if(request()->hasFile('purchaseOrder')) {
        		self::storeSingleFileMultimedia(
        			request()->file('purchaseOrder'), 
	                'documents_orders', 
	                'order', 
	                'purchase_order_file', 
	                'order_id', 
	                $order_id
        		);
        	}

            if (isset($data['consignment']['consignment_number'])) {
            	$consignment_id = DB::table('consignments')->insertGetId([
            		'consignment_number' => $data['consignment']['consignment_number'],
            		'order_id' => $order_id,
            		'created_at' => Carbon::now('America/Bogota'),
            		'updated_at' => Carbon::now('America/Bogota'),
            	]);

            	if(request()->file('consignment')) {
            		self::storeSingleFileMultimedia(
            			request()->file('consignment')['imagen'], 
		                'consignments', 
		                'consignment', 
		                'consignment_file', 
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
                    'status' => 1,
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }

            return $order_id;
        });
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
			'orderDetails.remissions',
			'client',
			'creator',
			'consignments'
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

		if(request()->hasFile('contract')) {
			self::destroyMultimediaByReason('contract_file','order_id',$order->id);
    		self::storeSingleFileMultimedia(
    			request()->file('contract'), 
                'documents_orders', 
                'order', 
                'contract_file', 
                'order_id', 
                $order->id
    		);
    	}
    	
    	if(request()->hasFile('purchaseOrder')) {
    		self::destroyMultimediaByReason('purchase_order_file','order_id',$order->id);
    		self::storeSingleFileMultimedia(
    			request()->file('purchaseOrder'), 
                'documents_orders', 
                'order', 
                'purchase_order_file', 
                'order_id', 
                $order->id
    		);
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
		        	'status' => 1
		        ]
		    );
		}

		if ($data->get('send_email')) {
			Notification::route('mail', $order->client->email)
							->notify(new UpdatedOrder($order));
		}

		if ($data->get('pse_url')) {
			Notification::route('mail', $order->client->email)
							->notify(new PaymentLink($order));
		}
		return $order;
	}

	public static function sendEmailUpdateTrait($id)
	{
		$order = self::findOrder($id);

		if ($order) {
			Notification::route('mail', $order->client->email)
							->notify(new UpdatedOrder($order));
			return response()->json([
				'type' => 'success',
				'text' => 'La notificación ha sido enviada.'
			],200);
		}
		return response()->json([
			'type' => 'error',
			'text' => 'No se encontró el pedido y la notificación no se envió.'
		],200);

		
	}

	public static function cancelOrder($id, $data)
	{
		$order = self::findOrder($id);
		if (count($order->consignments)) {
			return response()->json([
				'type' => 'info',
                'text' => 'No se puede cancelar este pedido porque ya existen consignaciones'
            ],200);
		}

		$data = $order->update([
			'note' => $data['note'],
			'status' => 'cancelado'
		]);

		if ($data) {
			return response()->json([
				'type' => 'success',
                'text' => 'El pedido se cancelo satisfactoriamente'
            ],200);
		}else{
			return response()->json([
				'type' => 'error',
                'text' => 'Sucedió un error, no se pudo cancelar'
            ],200);
		}
	}

	public static function updateStatusOrderTrait($id)
	{
		$order = self::findOrder($id);

		if ($order->status == 'cancelado') {
			$order->status = 'activo';
			$text = 'El pedido se activo con éxito';
		}
		
		if ($order->save()) {
			return response()->json([
				'order' => $order,
				'type' => 'success',
	            'text' => $text
	        ],200);
		}

		return response()->json([
			'type' => 'error',
            'text' => 'Sucedió un error, no se pudo actualizar'
        ],200);
	}

	public static function getOrdersByUserIdTrait()
	{
		$orders = Order::where('user_id', request()->get('id'))
					->where('status','activo')
					->get();

		if (count($orders)) {
			return response()->json([
				'orders' => $orders,
				'type' => 'success',
				'text' => 'Se encontraron ' . count($orders). ' pedidos'
			],200);
		}

		return response()->json([
			'orders' => $orders,
			'type' => 'info',
			'text' => 'No se encontraron pedidos'
		],200);
	}

	public static function getOrdersByUserIdWithConsignmentsTrait()
	{
		$isCredit = User::find(request()->get('id'))->details;

		$orders = [];
		if ($isCredit->type_pay == 'crédito') {

			$orders = Order::where('user_id', request()->get('id'))
					->where('status','activo')
					->get();
		}else{

			$orders = Order::where('user_id', request()->get('id'))
					->whereHas('consignments')
					->where('status','activo')
					->get();
		}

		if (count($orders)) {
			return response()->json([
				'orders' => $orders,
				'type' => 'success',
				'text' => 'Se encontraron ' . count($orders). ' pedidos'
			],200);
		}

		return response()->json([
			'orders' => $orders,
			'type' => 'info',
			'text' => 'No se encontraron pedidos'
		],200);
	}

	public static function getMultimediaOrderClientCredit($id)
	{
		$doc_contract = self::getMultimediaByParams('order', 'order_id', $id, 'contract_file');
        $doc_purchase_order = self::getMultimediaByParams('order', 'order_id', $id, 'purchase_order_file');
        $array = [];

        if (count($doc_contract)) {
            $array[] = $doc_contract[0];
        }

        if (count($doc_purchase_order)) {
            $array[] = $doc_purchase_order[0];
        }

        return $array;
	}
}
