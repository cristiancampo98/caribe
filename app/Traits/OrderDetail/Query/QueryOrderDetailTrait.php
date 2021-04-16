<?php

namespace App\Traits\OrderDetail\Query;

use App\Models\OrderDetail;

trait QueryOrderDetailTrait {

	public static function getOrderDetailWithRelationships($id)
	{
		return OrderDetail::where('id', $id)
		->with('order','product','remissions')
		->first();
	}
}