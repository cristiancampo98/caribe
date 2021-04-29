<?php

namespace App\Http\Controllers;

use App\Traits\ProductTrait;
use App\Traits\Product\Query\QueryProductTrait;
use Illuminate\Http\Request;

class ProductStorageController extends Controller
{
	use ProductTrait;
    use QueryProductTrait;
    
    public function getPaginateAllProducts()
    {
    	return self::getPaginateAllProductsTrait();
    }

    public function getMultimediaFilesByProduct($id)
    {
    	return self::getMultimediaFilesByProductTrait($id);
    }

    public function getTotalDeliveredByProductToday($id)
    {
        return self::getTotalDeliveredByProductTodayTrait($id);
    }

    public function editProductionLimits()
    {
        $data = self::getAllLimitsProducts();
        return inertia('Product/Limits',[
            'products' => $data
        ]);
    }

    public function updateLimits(Request $request, $id)
    {
        $this->validate($request, [
            'limit_day' => 'required|numeric|min:1|max:999.9'
        ]);
        $response = self::updateProduct($id, $request);

        if ($response) {
            $type = 'success';
            $text = 'El límite de producción del producto ha sido actualizado';
        } else {
            $type = 'error';
            $text = 'El límite de producción del producto no ha sido actualizado';
        }

        return response()->json([
            'type' => $type,
            'text' => $text
        ],200);
    }
}
