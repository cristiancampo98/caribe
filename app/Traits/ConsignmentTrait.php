<?php

namespace App\Traits;

use App\Models\Consignment;
use App\Traits\MultimediaTrait;
use Illuminate\Support\Facades\Auth;

/**
 * 
 */
trait ConsignmentTrait
{
	use MultimediaTrait;

	public static function storeConsignment()
	{
		$data = Consignment::create( request()->all());
		if (request()->hasFile('imagen')) {
			self::storeSingleFileMultimedia(
				request()->file('imagen'), 
				'consignments', 
				'consignment', 
				'consignment', 
				'user_id', 
				$data->id
			);
		}
	}

	public static function getAllConsignmentsByRol()
	{
		$isAdmin = false;
		$data = [];
		$isAdmin = Auth::user()->isAdmin();
		if ($isAdmin) {
			$data = Consignment::with([
				'order.client'
			])
			->paginate( request()->get('lenght'));
		}else{
			$data = self::getAllConsignmentsById();
		}
		return $data;
	}

	public static function getAllConsignmentsById()
	{
		return ['single user'];
	}

	public static function findConsignment($id)
	{
		return Consignment::find($id);
	}

	public static function updateConsignment($id)
	{
		return Consignment::find($id)
		->update(request()->all());
	}
	
}
