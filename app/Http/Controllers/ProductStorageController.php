<?php

namespace App\Http\Controllers;

use App\Traits\ProductTrait;
use Illuminate\Http\Request;

class ProductStorageController extends Controller
{
	use ProductTrait;
    
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
}
