<?php

namespace App\Traits;

use App\Models\Consignment;
use App\Traits\Consignment\Query\QueryConsignmentFromOrderTrait;
use App\Traits\MultimediaTrait;
use App\Traits\OrderDetailTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
trait ConsignmentTrait
{
    use MultimediaTrait, OrderDetailTrait, QueryConsignmentFromOrderTrait; 


    public static function storeConsignment()
    {
        if (self::validateWhenConsignmentIsFilled(request()->all())) {
            $fully_apply = request()->get('fully_apply');
            if (count(self::getConsignmentsByOrderId(request()->get('order_id')))) {
                $fully_apply = 0;
            }

            $data = (new Consignment)->fill(request()->all());
            $data->fully_apply = $fully_apply;
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
                'order.client.details',
                'detail.order.client'
            ]);
        } else {
            $data = self::getAllConsignmentsById();
        }

        if (request()->filled('name')) {
            $data->whereHas('order.client.details', function(Builder $query) {
                $query->where('name','like','%'.request()->get('name').'%')
                ->orWhere('name_company','like','%'.request()->get('name').'%');
            });
        }

        if (request()->filled('consignment_number')) {
            $data->where('consignment_number', 'like','%'.request()->get('consignment_number').'%');
        }

        if (request()->filled('fully_apply')) {
            $data->where('fully_apply', request()->get('fully_apply'));
        }

        if (request()->filled('start_date') && request()->filled('end_date')) {
            $data->whereBetween('created_at',[request()->get('start_date'), request()->get('end_date')]);
        }

        return $data->orderBy('id', 'desc')
            ->paginate(request()->get('lenght'));
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
