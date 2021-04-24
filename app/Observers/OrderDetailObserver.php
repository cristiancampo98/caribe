<?php

namespace App\Observers;

use App\Models\OrderDetail;

class OrderDetailObserver
{
    /**
     * Handle the OrderDetail "created" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function created(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the OrderDetail "updated" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function updated(OrderDetail $orderDetail)
    {
        $active = OrderDetail::where('order_id', $orderDetail->order_id)
                ->where('status',1)
                ->get();

        if (count($active)) {
            $orderDetail->order->status = 'activo';
            $orderDetail->order->save();
        } else {
            $orderDetail->order->status = 'finalizado';
            $orderDetail->order->save();
        }
    }

    /**
     * Handle the OrderDetail "deleted" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function deleted(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the OrderDetail "restored" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function restored(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the OrderDetail "force deleted" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function forceDeleted(OrderDetail $orderDetail)
    {
        //
    }
}
