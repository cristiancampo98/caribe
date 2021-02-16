<?php

namespace App\Http\Controllers;

use App\Traits\OrderTrait;
use Illuminate\Http\Request;


class OrderStorageController extends Controller
{
    use OrderTrait;

    public function getAllOrders()
    {
        return self::getOrdersByRole();
    }

    public function getOrderByConsecutiveOrClient()
    {
    	return self::getOrderByConsecutiveOrClientTrait();
    }

    public function getOrdersByUserId()
    {
    	return self::getOrdersByUserIdTrait();
    }
}
