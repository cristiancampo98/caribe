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
		if (self::validateWhenConsignmentIsFilled(request()->all())) {
			$data = Consignment::create( request()->all());
			if (request()->hasFile('imagen')) {
				self::storeSingleFileMultimedia(
					request()->file('imagen'), 
					'consignments', 
					'consignment', 
					'consignment_file', 
					'consignment_id', 
					$data->id
				);
			}
			return $data;
		}
		return false;

		
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

	public static function getMultimediaConsignmentsByOrderTrait()
	{
		$consignments = Consignment::where('order_id', request()->get('id'))
		->select('id')
		->get()
		->pluck('id');
		
		return self::getMultimediaByWhereIn($consignments,'consignment_id');
	}

	public static function validateWhenConsignmentIsFilled($data)
	{
		if ($data['consignment_number'] || $data['pse_url'] 
			|| $data['pse_number'] || isset($data['imagen'])) {
			return true;
		}
		return false;
	}
	
}
