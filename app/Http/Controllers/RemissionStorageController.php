<?php

namespace App\Http\Controllers;

use App\Traits\RemissionTrait;
use Illuminate\Http\Request;

class RemissionStorageController extends Controller
{
	use RemissionTrait;

    public function getPaginateAllRemissions()
    {
    	return self::getPaginateAllRemissionsTrait();
    }

    public function getMultimediaFilesByRemission($id)
    {
    	return self::getMultimediaFilesByRemissionTrait($id);
    }
}
