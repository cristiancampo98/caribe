<?php

namespace App\Http\Controllers;

use App\Traits\PermissionTrait;
use Illuminate\Http\Request;

class PermissionStorageController extends Controller
{
	use PermissionTrait;

    public function getPaginateAllPermissions()
    {
    	return self::getPaginateAllPermissionsTrait();
    }
}
