<?php

namespace App\Traits;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
trait VehicleTrait
{
	public static function storeVehicleFromClient($data,$user_id)
	{
		$vehicles = explode(',', $data);
		foreach ($vehicles as $value) {
			$vehicle = Vehicle::firstOrCreate(
			    ['license_plate' => str_replace(' ', '', $value)],
			    ['state' => 1]
			);

			$vehicle->users()->sync($user_id);
		}
	}

	public static function getAllVehicles()
	{
		return DB::table('sys_users')
            ->join('vehicle_users', 'sys_users.id', '=', 'vehicle_users.user_id')
            ->join('vehicles', 'vehicle_users.vehicle_id', '=', 'vehicles.id')
            ->select('vehicles.*','vehicles.id as consecutivo','sys_users.email','vehicle_users.carrier','vehicle_users.id as id')
            ->get();
	}
}
