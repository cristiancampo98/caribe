<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

/**
 * 
 */
trait ProductTrait
{
	public static function storeProduct($data)
	{
		$product = (new Product)->fill($data);
		$product->user_id = Auth::id();
		$product->save();
		return $product;
	}

    
}
