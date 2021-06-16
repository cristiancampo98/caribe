<?php

namespace App\Traits\Consignment\Query;

use App\Models\Consignment;

trait QueryConsignmentFromOrderTrait 
{
	public static function getConsignmentsByOrderId($order_id)
	{
		return Consignment::where('order_id',$order_id)->get();
	}
}