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
	    'unit_measure_id',
	    'price',
	    'description'
    ];

    protected $with = ['units_measure'];

    public function units_measure()
    {
        return $this->belongsTo(UnitMeasure::class, 'unit_measure_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
