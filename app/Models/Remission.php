<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remission extends Model
{
    use HasFactory;

    protected $table = 'remissions';

    protected $fillable = [
    	'delivered',
    	'order_details_id',
    	'vehicle_users_id',
    	'created_by'
    ];

    public function orderDetail()
    {
    	return $this->belongsTo(OrderDetail::class, 'order_details_id');
    }

    public function creator()
    {
    	return $this->belongsTo(User::class, 'created_by');
    }

    public function carrier()
    {
    	return $this->belongsTo(VehicleUser::class, 'vehicle_users_id');
    }


}
