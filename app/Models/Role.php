<?php

namespace App\Models;

use App\Traits\RoleTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    use RoleTrait;

    protected $table = 'roles';

    protected $with = ['permissions'];

    protected $fillable = [
    	'name',
    	'slug',
    	'description',
    	'full-access',
    	'public'
    ];
}
