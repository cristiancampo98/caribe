<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUser extends Model
{
    use HasFactory;

    protected $table = 'vehicle_users';

    protected $fillable = ['user_id','vehicle_id','carrier'];
}