<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;


class OrderStorageController extends Controller
{
    use OrderTrait;

    public function getAllOrders()
    {
        return self::getOrdersByRole();
    	
    }
}
