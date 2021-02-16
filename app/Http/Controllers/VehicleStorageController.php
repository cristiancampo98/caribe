<?php

namespace App\Http\Controllers;

use App\Traits\VehicleTrait;
use Illuminate\Http\Request;

class VehicleStorageController extends Controller
{
    use VehicleTrait;

    public function getPaginateAllVehicles()
    {
        return self::getVehiclesPaginate();
    }
}
