<?php

namespace App\Models;

use App\Traits\MultimediaTrait;
use App\Traits\ProductTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use MultimediaTrait;
    use ProductTrait;

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
}
