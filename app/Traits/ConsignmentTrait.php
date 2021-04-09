<?php

namespace App\Traits;

use App\Models\Consignment;
use App\Traits\MultimediaTrait;
use App\Traits\OrderDetailTrait;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
trait ConsignmentTrait
{
    use MultimediaTrait, OrderDetailTrait;


    public static function storeConsignment()
    {
        if (self::validateWhenConsignmentIsFilled(request()->all())) {

            $data = (new Consignment)->fill(request()->all());
            $data->created_by = Auth::id();
            $data->save();

            if (request()->get('fully_apply')) {
                self::updateOrderDetailWhenConsignmentFully($data->id);
            } else {
                self::updateOrderDetailWhenConsignmentPartial(request()->get('details_order'), $data->id);
            }

            if (request()->hasFile('imagen')) {
                self::storeSingleFileMultimedia(
                    request()->file('imagen'),
                    'consignments',
                    'consignment',
                    'consignment_file',
                    'consignment_id',
                    $data->id
                );
            }
            return $data;
        }
        return false;
    }

    public static function getAllConsignmentsByRol()
    {
        $isAdmin = false;
        $data = [];
        $isAdmin = Auth::user()->isAdmin();
        if ($isAdmin) {
            $data = Consignment::with([
                'order.client',
                'detail.order.client'
            ])
            ->orderBy('id', 'desc')
            ->paginate(request()->get('lenght'));
        } else {
            $data = self::getAllConsignmentsById();
        }
        return $data;
    }

    public static function getAllConsignmentsById()
    {
        return ['single user'];
    }

    public static function findConsignment($id)
    {
        return Consignment::where('id', $id)
            ->with('order.client')
            ->first();
    }

    public static function getMultimediaConsignmentsByOrderTrait()
    {
        $consignments = Consignment::where('order_id', request()->get('id'))
            ->select('id')
            ->get()
            ->pluck('id');

        return self::getMultimediaByWhereIn($consignments, 'consignment_id');
    }

    public static function validateWhenConsignmentIsFilled($data)
    {
        if ($data['consignment_number'] || isset($data['imagen'])) {
            return true;
        }
        return false;
    }

    public static function destroyConsignmentTrait($id)
    {
        self::destroyMasiveMultimediaByParams([$id], 'consignment_id');
        self::updateOrderDetailWhenDeleteConsignment($id);
        $consignments = Consignment::find($id);

        return $consignments->delete();
    }

    public static function getMultimediaFilesByConsignmentTrait($id)
    {
        return self::getMultimediaByParams(
            'consignment',
            'consignment_id',
            $id,
            'consignment_file'
        );
    }

    public static function getConsignmentByIdWithRelationship($id)
    {
        return Consignment::where('id', $id)
            ->with([
                'order.client',
                'detail.product',
                'detail.order.client',
                'creator',
            ])
            ->first();
    }

    public static function canTakenConsignment($id)
    {
        $consignment = Consignment::find($id);
        if ($consignment->taken) {
            return false;
        }
        return true;
    }
}
