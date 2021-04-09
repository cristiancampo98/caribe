<?php

namespace App\Traits;

use App\Models\Remission;
use App\Traits\MultimediaTrait;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
trait RemissionTrait
{
    use MultimediaTrait;

    public static function storeRemission($data)
    {
        $remission = (new Remission)->fill($data->all());
        $remission->created_by = Auth::id();
        $remission->save();

        return $remission;
    }

    public static function getPaginateAllRemissionsTrait()
    {
        return Remission::with(
            'orderDetail.order',
            'orderDetail.product',
            'creator',
            'carrier.client',
            'carrier.vehicle'
        )
            ->orderBy('id', 'desc')
            ->paginate(request()->get('lenght'));
    }

    public static function getMultimediaFilesByRemissionTrait($id)
    {
        $firm = self::getMultimediaByParams('remission', 'remission_id', $id, 'remission_firm');
        $plate = self::getMultimediaByParams('remission', 'remission_id', $id, 'remission_plate');
        $delivery = self::getMultimediaByParams('remission', 'remission_id', $id, 'remission_delivery');
        $array = [];

        if (count($firm)) {
            $array[] = $firm[0];
        }

        if (count($plate)) {
            $array[] = $plate[0];
        }

        if (count($delivery)) {
            $array[] = $delivery[0];
        }

        return $array;
    }

    public static function getRemissionByIdWithRelationships($id)
    {
        return Remission::where('id', $id)
            ->with(
                'orderDetail.order.client',
                'orderDetail.product',
                'creator',
                'carrier.vehicle'
            )
            ->first();
    }
}
