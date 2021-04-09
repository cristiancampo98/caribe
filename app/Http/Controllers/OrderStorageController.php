<?php

namespace App\Http\Controllers;

use App\Traits\OrderTrait;
use App\Traits\Order\QueryOrder\QueryOrderTrait;
use Illuminate\Http\Request;


class OrderStorageController extends Controller
{
    use OrderTrait;
    use QueryOrderTrait;

    public function getAllOrders()
    {
        return self::getOrdersByRole();
    }

    public function getOrderByConsecutiveOrClient()
    {
    	return self::getOrderByConsecutiveOrClientTrait();
    }

    public function getOrdersByUserId(Request $request)
    {
    	return self::getAllOrdersByClient( $request->id );
    }

    public function getOrdersByUserIdToRemission(Request $request)
    {
        return self::getOrdersByUserIdWithConsignmentsTrait( $request->id );
    }

    public function getMultimediaOrdersById($id)
    {
        return self::getMultimediaOrderClientCredit($id);
    }
}
