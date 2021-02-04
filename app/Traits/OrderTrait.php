<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
}
