<?php

namespace App\Traits;

use App\Models\Product;
use App\Traits\MultimediaTrait;
use Illuminate\Support\Facades\Auth;

/**
 * 
 */
trait ProductTrait
{
	use MultimediaTrait;

	public static function storeProduct($data)
	{
		$product = (new Product)->fill($data);
		$product->user_id = Auth::id();
		$product->save();

		if (count($data['photos'])) {

            self::storeMultimedia(
            	$data['photos'], 
            	'products', 
            	'product', 
            	'img_product',
            	'product_id', 
            	$product->id
            );
        }
		return $product;
	}

	public static function getPaginateAllProductsTrait()
	{
		$products = Product::orderBy('id','desc')->paginate( request()->get('lenght'));

		return $products;
	}

	public static function findProduct($id)
	{
		return Product::find($id);
	}

	public static function updateProduct($id, $data)
	{
		$product = self::findProduct($id);

		if (count($data['photos'])) {

			self::storeMultimedia(
				$data['photos'], 
				'products', 'product', 
				'img_product',
				'product_id', 
				$product->id
			);
		}

		return $product->update($data->all());
	}

	public static function getProductWithAllData($id)
	{
		return Product::where('id', $id)
				->with('creator')
				->first();
	}

	public static function getMultimediaFilesByProductTrait($id)
	{
		return self::getMultimediaByParams(
					'product',
					'product_id', 
					$id, 
					'img_product'
				);
	}

	public static function updateStatusProduct($id)
	{
		$product = self::findProduct($id);
		$text = 'Sucedió un error, no se cambio el estado del producto';

		if ($product->status) {
			$product->status = 0;
			$text = 'El producto se inactivo con éxito';

		}else {
			$product->status = 1;
			$text = 'El producto se activo con éxito';
		}

		if ($product->save()) {

			return response()->json([
				'status' => $product->status,
				'type' => 'success',
				'text' => $text
			], 200);
		}
		
		return response()->json([
			'status' => $product->status,
			'type' => 'success',
			'text' => $text
		], 200);
	}

	public static function getAllProductsToOrder()
	{
		return Product::where('status',1)
				->get();
	}
    
}
