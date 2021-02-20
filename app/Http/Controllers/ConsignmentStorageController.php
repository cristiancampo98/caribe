<?php

namespace App\Http\Controllers;

use App\Traits\ConsignmentTrait;
use Illuminate\Http\Request;

class ConsignmentStorageController extends Controller
{
	use ConsignmentTrait;

	public function getAllConsignments()
	{
		return self::getAllConsignmentsByRol();
	}

	public function getMultimediaConsignmentsByOrder()
	{
		return self::getMultimediaConsignmentsByOrderTrait();
	}
    
}
