<?php

namespace App\Traits\Product\Query;

use App\Models\Product;

trait QueryProductTrait 
{
	public static function getAllLimitsProducts()
	{
		return Product::select('id','name','limit_day')->where('status',1)->get();
	}

	
}