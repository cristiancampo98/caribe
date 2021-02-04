<?php

namespace App\Models;

use App\Traits\OrderTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use OrderTrait;

    protected $table = 'orders';

    protected $fillable = [
    	'user_id',
    	'shipping_address',
    	'city',
    	'note',
    	'status',
    	'total',
    	'created_by'
    ];
}
