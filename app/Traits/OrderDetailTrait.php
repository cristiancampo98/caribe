<?php

namespace App\Traits;

use App\Models\OrderDetail;

/**
 * 
 */
trait OrderDetailTrait
{
	

	public static function getOrderDetailsByOrderTrait()
	{
		$details = OrderDetail::where('order_id', request()->get('id'))
					->with('product','order.consignments','remissions')
					->get();

		if (count($details)) {
			return response()->json([
				'details' => $details,
				'type' => 'success',
				'text' => 'Se cargo con exito el detalle del pedido'
			],200);
		}

		return response()->json([
			'details' => $details,
			'type' => 'info',
			'text' => 'No se encontró el detalle'
		],200);
	}
}
