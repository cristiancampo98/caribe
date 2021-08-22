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
        'place_loading',
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

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function consignments()
    {
        return $this->hasMany(Consignment::class, 'order_id', 'id');
    }

    public function remissions()
    {
        return $this->hasManyThrough(
            Remission::class,
            OrderDetail::class,
            'order_id', // Foreign key on the environments table...
            'order_details_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }
}
