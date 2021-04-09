<?php

namespace App\Traits\Remission\Update;

use App\Models\Remission;
use App\Traits\MultimediaTrait;

trait UpdateRemissionTrait {

	use MultimediaTrait;

	public static function updateRemission($id, $data) 
	{
		if ($data->hasFile('firm')) {
            self::storeSingleFileMultimedia(
                $data->file('firm'),
                'remission',
                'remission',
                'remission_firm',
                'remission_id',
                $id
            );
        }

        if ($data->hasFile('plate')) {
            self::storeSingleFileMultimedia(
                $data->file('plate'),
                'remission',
                'remission',
                'remission_plate',
                'remission_id',
                $id
            );
        }

        if ($data->hasFile('delivery')) {
            self::storeSingleFileMultimedia(
                $data->file('delivery'),
                'remission',
                'remission',
                'remission_delivery',
                'remission_id',
                $id
            );
        }
        $remission = Remission::find($id);
		$remission->update([
			'delivered' => $data->delivered,
			'vehicle_users_id' => $data->vehicle_users_id,
		]);
		return $remission;
	}
}