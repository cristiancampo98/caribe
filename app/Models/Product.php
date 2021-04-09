<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
	    'name',
	    'reference',
	    'description',
        'cubic_meters',
        'ton',
        'limit_day',
        'user_id',
        'status'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
