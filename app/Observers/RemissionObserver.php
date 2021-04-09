<?php

namespace App\Observers;

use App\Models\Remission;

class RemissionObserver
{
    /**
     * Handle the Remission "created" event.
     *
     * @param  \App\Models\Remission  $remission
     * @return void
     */
    public function created(Remission $remission)
    {
        $total = Remission::where('order_details_id', $remission->order_details_id)->sum('delivered');

        if ($total == $remission->orderDetail->quantity) {
            
            $remission->orderDetail->status = 0;
            $remission->orderDetail->save();
        }
    }

    /**
     * Handle the Remission "updated" event.
     *
     * @param  \App\Models\Remission  $remission
     * @return void
     */
    public function updated(Remission $remission)
    {
        //
    }

    /**
     * Handle the Remission "deleted" event.
     *
     * @param  \App\Models\Remission  $remission
     * @return void
     */
    public function deleted(Remission $remission)
    {
        //
    }

    /**
     * Handle the Remission "restored" event.
     *
     * @param  \App\Models\Remission  $remission
     * @return void
     */
    public function restored(Remission $remission)
    {
        //
    }

    /**
     * Handle the Remission "force deleted" event.
     *
     * @param  \App\Models\Remission  $remission
     * @return void
     */
    public function forceDeleted(Remission $remission)
    {
        //
    }
}
