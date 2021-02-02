<?php

namespace App\Models;

use App\Models\Item;
use App\Traits\MenuAccessTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    use MenuAccessTrait;

    protected $table = 'menus';

    protected $fillable = [
    	'name',
    	'slug',
    	'description',
    	'icon',
    	'available',
    	'position'
    ];

     public function items()
    {
        return $this->hasMany(Item::class);
    }
}
