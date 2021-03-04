<?php

namespace App\Http\Controllers;

use App\Traits\OrderDetailTrait;
use Illuminate\Http\Request;

class OrderDetailStorageController extends Controller
{
	use OrderDetailTrait;

    public function getOrderDetailsByOrderId()
    {
    	return self::getOrderDetailsByOrderTrait();
    }
}
