<?php

namespace App\Http\Controllers;

use App\Traits\MenuTrait;

class MenuStorageController extends Controller
{
	use MenuTrait;
	
    public function getPaginateAllMenus()
    {
    	return self::getPaginateAllMenusTrait();
    }
}
