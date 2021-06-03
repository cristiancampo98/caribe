<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
	protected $role;

	public function __construct()
	{
		$this->role = new Role;

	}

    public function assignPermission($id)
    {
    	$role = $this->role->getPermissionsByRol($id);
    	$permissions = Permission::all()->sortBy('controller')->groupBy('controller');
    	return inertia('Security/AssignPermission', [
    		'permissions' => $permissions, 
    		'role' => $role
    	]);
    }
}
