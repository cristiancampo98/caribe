<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUser extends Model
{
    use HasFactory;

    protected $table = 'vehicle_users';

    protected $fillable = ['user_id','vehicle_id','carrier','identification_number'];

    public function vehicle()
    {
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function client()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
