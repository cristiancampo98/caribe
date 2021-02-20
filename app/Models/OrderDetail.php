<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
    	'order_id',
    	'product_id',
    	'quantity',
    	'status',
    ];

    public function order(){
    	return $this->belongsTo(Order::class);
    }

    public function product(){
    	return $this->belongsTo(Product::class);
    }

    public function remissions()
    {
        return  $this->hasMany(Remission::class, 'order_details_id');
    }
}
