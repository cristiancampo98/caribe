<?php

namespace App\Http\Controllers;

use App\Traits\MultimediaTrait;
use App\Traits\VehicleTrait;
use Illuminate\Http\Request;

class VehicleStorageController extends Controller
{
    use VehicleTrait;
    use MultimediaTrait;

    public function getPaginateAllVehicles()
    {
        return self::getVehiclesPaginate();
    }

    public function getMultimediaFilesByVehicle($id){
    	return self::getMultimediaByParams(
    		'vehicle', 'vehicle_id', $id, 'photo_plate'
    	);
    }
}
