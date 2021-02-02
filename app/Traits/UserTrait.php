<?php

namespace App\Traits;

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
}
