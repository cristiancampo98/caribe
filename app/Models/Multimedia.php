<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    use HasFactory;

    protected $table = 'multimedias';

    protected $fillable = [
		'path',
		'filename',
		'model',
		'foreign_key',
		'model_id'
	];
}
