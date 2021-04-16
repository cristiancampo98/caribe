<?php

namespace App\Traits;

use App\Models\Remission;
use App\Traits\MultimediaTrait;
use App\Traits\Remission\Query\QueryRemissionTrait;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
trait RemissionTrait
{
    use MultimediaTrait;
    use QueryRemissionTrait;

    public static function storeRemission($data)
    {
        $remission = (new Remission)->fill($data->all());
        $remission->created_by = Auth::id();
        $remission->save();

        return $remission;
    }

    public static function getPaginateAllRemissionsTrait()
    {

        $remissions = Remission::with(
            'orderDetail.order',
            'orderDetail.product',
            'creator',
            'carrier.client',
            'carrier.vehicle'
        )
            ->orderBy('id', 'desc')
            ->paginate(request()->get('lenght'));

        return self::remissionsAreSigned($remissions);
    }

    public static function remissionsAreSigned($remissions)
    {
        foreach ($remissions as $value) {
            $firm = self::getMultimediaByParams('remission', 'remission_id', $value->id, 'remission_firm');
            $isSigned = count($firm);
            $value->isSigned = $isSigned;
        }
        return $remissions;

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
        $data = Remission::where('id', $id)
            ->with(
                'orderDetail.order.client',
                'orderDetail.product',
                'orderDetail.remissions',
                'creator',
                'carrier.vehicle'
            )
            ->first();
        $data->orderDetail->limit = $data->delivered + $data->orderDetail->product->limit_day - self::getRemissionByProductTrait($data->orderDetail->product_id);
        return $data;
    }
}
