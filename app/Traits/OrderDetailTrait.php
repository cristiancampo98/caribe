<?php

namespace App\Traits;

use App\Models\OrderDetail;

/**
 *
 */
trait OrderDetailTrait
{


    public static function getOrderDetailsByOrderTrait()
    {
        $details = OrderDetail::where('order_id', request()->get('id'))
            ->with('product', 'order.client.details', 'remissions')
            ->get();

        if (count($details)) {
            return response()->json([
                'details' => $details,
                'type' => 'success',
                'text' => 'Se cargo con exito el detalle del pedido'
            ], 200);
        }

        return response()->json([
            'details' => $details,
            'type' => 'info',
            'text' => 'No se encontró el detalle'
        ], 200);
    }

    public static function updateOrderDetailWhenConsignmentFully($consignment_id)
    {
        return OrderDetail::where('order_id', request()->get('order_id'))
            ->whereNull('consignment_id')
            ->update([
                'consignment_id' => $consignment_id
            ]);
    }

    public static function updateOrderDetailWhenConsignmentPartial($details_order, $consignment_id)
    {
        $ids = [];
        foreach ($details_order as $value) {
            if ($value['apply']) {
                $ids[] = $value['order_details_id'];
            }
        }
        return OrderDetail::whereIn('id', $ids)
            ->update([
                'consignment_id' => $consignment_id
            ]);
    }

    public static function updateOrderDetailWhenUpdateConsignment($detail_id, $consignment_value) 
    {

        return OrderDetail::where('id', $detail_id)
                ->update([
                    'consignment_id' => $consignment_value
                ]);
    }

    public static function updateOrderDetailWhenDeleteConsignment($consignment_id)
    {
        return OrderDetail::where('consignment_id', $consignment_id)
        ->update([
            'consignment_id' => null
        ]);

    }
}
