<?php

namespace App\Traits;

use App\Models\RoleUser;
use Illuminate\Support\Facades\Auth;

/**
 * 
 */
trait UserTrait
{

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role','role_users','user_id','role_id');
    }

    public function havePermission($permission)
    {
        $isTrue = false;
        
        if (! empty($this->roles)) {
            foreach ($this->roles as $role) {
                
                if ($role['full-access'] == 'yes') {
                    $isTrue = true;
                    break;

                }
            }
        }
        
        if (! empty($this->role->permissions)) {
            foreach ($this->role->permissions as $perm) {
                if ($perm->slug == $permission) {
                    $isTrue = true;
                    break;

                }
            }
        }
        
        return $isTrue;
        
    }

    /*
     * Valida si el usuario logueado tiene un rol administrador y retorna un boolean
     *
     */
    public function isAdmin(){

        $isAdmin = false;

        foreach (Auth::user()->roles as $key => $value) {
            if ( $value['full-access'] == 'yes' || $value->id == 2) {
                $isAdmin = true;
            }
        }

        return $isAdmin;
    }

    public static function getClients(){
        
        return RoleUser::where('role_id',3)->get();
    }
}
