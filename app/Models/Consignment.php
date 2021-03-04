<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    use HasFactory;

    protected $table = 'consignments';

    protected $fillable = [
    	'order_id',
    	'consignment_number',
        'taken'
    ];

    public function order()
    {
    	return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
