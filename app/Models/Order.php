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
    	'city',
    	'note',
    	'status',
    	'total',
    	'created_by'
    ];

    protected $with = ['client','creator'];

    public function client(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
