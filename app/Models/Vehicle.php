<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $table = 'vehicles';
    protected $fillable = ['license_plate','brand','state','reason'];
    protected $with = ['users'];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'vehicle_users', 'vehicle_id', 'user_id')
        ->withPivot('id','carrier');
    }
}
