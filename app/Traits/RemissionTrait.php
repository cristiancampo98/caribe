<?php

namespace App\Traits;

use App\Models\Remission;
use App\Traits\MultimediaTrait;
use App\Traits\Remission\Query\QueryRemissionTrait;
use Illuminate\Database\Eloquent\Builder;
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
            'orderDetail.order.client.details',
            'orderDetail.product',
            'orderDetail.consignment',
            'creator',
            'carrier.client',
            'carrier.vehicle'
        );

        if (request()->filled('name')) {
            $remissions->whereHas('orderDetail.order.client.details', function(Builder $query) {
                $query->where('name','like','%'.request()->get('name').'%')
                ->orWhere('name_company','like','%'.request()->get('name').'%');
            });
        }

        if (request()->filled('order_id')) {
            $remissions->whereHas('orderDetail.order', function(Builder $query) {
                $query->where('id','like','%'.request()->get('order_id').'%');
            });
        }

        if (request()->filled('start_date') && request()->filled('end_date')) {
            $remissions->whereBetween('created_at',[request()->get('start_date'), request()->get('end_date')]);
        }

        if (request()->filled('isSigned')) {
            $remissions->where('isSigned', request()->get('isSigned'));
        }

        $data = $remissions->orderBy('id', 'desc')->paginate(request()->get('lenght'));

        return self::remissionsAreSigned($data);

        
    }

    public static function remissionsAreSigned($remissions)
    {
        foreach ($remissions as $value) {
            $firm = self::getMultimediaByParams('remission', 'remission_id', $value->id, 'remission_firm');
            if (count($firm)) {
                $value->isSigned = 1;
                $value->save();
            }
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
                'orderDetail.consignment',
                'creator',
                'carrier.vehicle'
            )
            ->first();
        $data->files = self::getMultimediaFilesByRemissionTrait($id);
        $data->orderDetail->limit = $data->delivered + $data->orderDetail->product->limit_day - self::getRemissionByProductTrait($data->orderDetail->product_id);
        return $data;
    }
}
