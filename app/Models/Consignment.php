<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    use HasFactory;

    protected $table = 'consignments';

    protected $fillable = [
        'consignment_number',
        'available',
        'fully_apply',
        'order_id',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function detail()
    {
        return $this->hasMany(OrderDetail::class, 'consignment_id', 'id');
    }
}
