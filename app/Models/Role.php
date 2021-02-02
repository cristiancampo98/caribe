<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
    	'name',
    	'slug',
    	'description',
    	'full-access',
    	'public'
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission','permission_roles','role_id','permission_id');
    }
}
