<?php

namespace App\Traits;

use App\Models\Permission;

/**
 * 
 */
trait PermissionTrait
{
    public static function getPaginateAllPermissionsTrait()
    {
    	return Permission::orderBy('id','desc')->paginate( request()->get('lenght'));
    }
}
