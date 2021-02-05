<?php

namespace App\Traits;

use App\Models\Role;

/**
 * 
 */
trait RoleTrait
{

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission','permission_roles','role_id','permission_id');
    }

    public function getPermissionsByRol($id)
    {
    	return Role::find($id);
    }
}
