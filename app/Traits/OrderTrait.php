<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
trait OrderTrait
{
	protected $user;

	public function __construct()
	{
		$this->user = new User;
	}
	/*
	 * Valida el rol del usuario para retornar todas o solo las ordenes del usuario logueado
	 */
	public function getOrdersByRole(){

		$isAdmin = Auth::user()->isAdmin();
		$orders = [];

		$orders = Order::where('user_id', Auth::id())->get();

		if ($isAdmin) {
			$orders = Order::all();
		}

		return $orders;
	}

	public function getClientsToOrder(){

		$isAdmin = Auth::user()->isAdmin();

		if ($isAdmin) {
			return $this->user->getClients();
		}

		return false;

	}

	public function storeOrder($data){
		return DB::transaction(function () use ($data ) {

            $date = Carbon::now('America/Bogota');

            $order_id = DB::table('orders')->insertGetId([
            	'user_id' => $data['user_id'],
                'shipping_address' => $data['shipping_address'],
                'city' => $data['city'],
                'note' => $data['note'],
                'status' => 'Pendiente',
                'total' => $this->getTotalOrder($data['order_details']),
                'created_by' => Auth::user()->id,
                'created_at' => $date,
                'updated_at' => $date
            ]);

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

	public function getTotalOrder($data)
	{
		$total = 0;

		foreach ($data as $key => $value) {
			$total += ($value['price'] * $value['quantity']) - $value['discount'];
		}

		return $total;

	}
}
