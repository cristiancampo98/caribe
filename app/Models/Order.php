<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
    	'user_id',
    	'shipping_address',
        'department',
    	'city',
    	'note',
        'delete_note',
    	'status',
        'pse_url',
        'pse_number',
    	'created_by'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function consignments()
    {
        return $this->hasMany(Consignment::class, 'order_id', 'id');
    }

    public function client(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    
}
