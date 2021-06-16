<?php

namespace App\Traits\Vehicle\Store;

use App\Models\Vehicle;

trait StoreVehicleTrait 
{
	public static function storeVehicle($req) 
	{
		$vehicle = Vehicle::create($req->all());

    	if ($vehicle) {
    		$vehicle->users()->sync($req->users_id);
    	}

    	return $vehicle;
	}
}