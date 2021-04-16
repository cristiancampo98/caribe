<?php

namespace App\Http\Controllers;

use App\Traits\RemissionTrait;
use App\Traits\Remission\Query\QueryRemissionTrait;
use Illuminate\Http\Request;

class RemissionStorageController extends Controller
{
	use RemissionTrait;
	use QueryRemissionTrait;

    public function getPaginateAllRemissions()
    {
    	return self::getPaginateAllRemissionsTrait();
    }

    public function getMultimediaFilesByRemission($id)
    {
    	return self::getMultimediaFilesByRemissionTrait($id);
    }

    public function getRemissionByProduct($id)
    {
    	return self::getRemissionByProductTrait($id);
    }
}
