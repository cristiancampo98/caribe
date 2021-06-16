<?php

namespace App\Traits\Consignment\Update;

use App\Models\Consignment;
use App\Traits\MultimediaTrait;
use App\Traits\OrderDetailTrait;

trait UpdateConsignment {

	use OrderDetailTrait;
	use MultimediaTrait;

	public static function updateConsignment($id) 
	{
		if (request()->get('fully_apply')) {

			Consignment::where('id',$id)
			->update([
				'consignment_number' => request()->get('consignment_number'),
				'order_id' => request()->get('order_id'),
				'fully_apply' => 1
			]);

			self::updateOrderDetailWhenConsignmentFully($id);
		} else {

			Consignment::where('id',$id)
			->update([
				'consignment_number' => request()->get('consignment_number'),
				'order_id' => request()->get('order_id'),
				'fully_apply' => 0
			]);

			foreach (request()->get('details_order') as $detail) {

				if ( isset($detail['remove']) ) {
					self::updateOrderDetailWhenUpdateConsignment($detail['order_details_id'],null);
				}

				if ( isset($detail['apply']) ) {
					self::updateOrderDetailWhenUpdateConsignment($detail['order_details_id'],$id);
				}
			}
		}

		if (request()->hasFile('imagen')) {
            self::destroyMasiveMultimediaByParams([$id], 'consignment_id');
            self::storeSingleFileMultimedia(
                request()->file('imagen'),
                'consignments',
                'consignment',
                'consignment_file',
                'consignment_id',
                $id
            );
        }
		return true;
	}

}