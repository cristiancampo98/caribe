<?php

namespace App\Traits\Order\QueryOrder;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
trait QueryOrderTrait
{

    public static function getAllOrdersByClient($id)
    {
        $response = [];

        $orders = Order::where('user_id', $id)
            ->whereHas('orderDetails', function (Builder $query) {
                $query->whereNull('consignment_id');
            })
            ->where('status', 'activo')
            ->get();

        if (count($orders)) {
            return response()->json([
                'orders' => $orders,
                'type' => 'success',
                'text' => 'Se encontraron ' . count($orders) . ' pedidos'
            ], 200);
        }

        return response()->json([
            'orders' => $orders,
            'type' => 'info',
            'text' => 'No se encontraron pedidos'
        ], 200);
    }

    public static function getOrdersByUserIdWithConsignmentsTrait()
    {
        $isCredit = User::find(request()->get('id'))->details;

        $orders = [];
        if ($isCredit->type_pay == 'crédito') {
            $text = 'No se encontraron pedidos a crédito';
            $orders = Order::where('user_id', request()->get('id'))
                ->where('status', 'activo')
                ->get();
        } else {
            $text = 'No se encontraron pedidos con consignaciones';
            $orders = Order::where('user_id', request()->get('id'))
                ->whereHas('consignments')
                ->where('status', 'activo')
                ->get();
        }

        if (count($orders)) {
            return response()->json([
                'orders' => $orders,
                'type' => 'success',
                'text' => 'Se encontraron ' . count($orders) . ' pedidos'
            ], 200);
        }

        return response()->json([
            'orders' => $orders,
            'type' => 'info',
            'text' => $text
        ], 200);
    }

    /*
	 * Valida el rol del usuario para retornar todas o solo las ordenes del usuario logueado
	 */
    public static function getOrdersByRole()
    {

        $isAdmin = Auth::user()->isAdmin();
        $orders = [];

        $orders = Order::with([
            'client',
            'creator',
            'remissions'
        ])
        ->where('user_id', Auth::id());

        if ($isAdmin) {
            $orders = Order::with([
                'client',
                'creator',
                'remissions'
            ]);

            if (request()->filled('name')) {
                $orders->whereHas('client.details', function(Builder $query) {
                    $query->where('name','like','%'.request()->get('name').'%')
                    ->orWhere('name_company','like','%'.request()->get('name').'%');
                });
            }
            if (request()->filled('type_pay')) {
                $orders->whereHas('client.details', function(Builder $query) {
                    $query->where('type_pay',request()->get('type_pay'));
                });
            }
        }
        
        if (request()->filled('status')) {
            $orders->where('status',request()->get('status'));
        }
        if (request()->filled('start_date') && request()->filled('end_date')) {
            $orders->whereBetween('created_at',[request()->get('start_date'), request()->get('end_date')]);
        }


        return $orders->orderBy('id', 'desc')->paginate(request()->get('lenght'));
    }
}
