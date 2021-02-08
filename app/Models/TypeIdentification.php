<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIdentification extends Model
{
    use HasFactory;

    protected $table = 'type_identifications';

    protected $fillable = [
    	'description',
    	'acronym',
    	'available'
    ];
}
