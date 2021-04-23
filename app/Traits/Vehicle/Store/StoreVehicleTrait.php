<?php

namespace App\Traits\Vehicle\Store;

use App\Models\Vehicle;

trait StoreVehicleTrait 
{
	public static function storeVehicle($req) 
	{
		$users = [];

		foreach ($req->users_id as $key => $value) {
			$users[] = $value['id'];
		}

		$vehicle = Vehicle::updateOrCreate(
    		[
    			'license_plate' => $req->get('license_plate')
    		],
    		$req->all()
    	);

    	if ($vehicle) {
    		$vehicle->users()->sync($users);
    	}

    	return $vehicle;
	}
}