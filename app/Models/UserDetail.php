<?php

namespace App\Models;

use App\Traits\UserDetailTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    use UserDetailTrait;

    protected $table = 'user_details';
    
    protected $fillable = [
    	'number_identification',
    	'type_identification_id',
    	'name_company',
    	'type_pay',
    	'street_address',
    	'street_details',
    	'street_comune',
    	'city',
    	'deparment',
    	'country',
    	'others_email',
    	'phones',
        'user_id'
    ];

    protected $with = ['typeIdentification'];

    public function typeIdentification()
    {
        return $this->belongsTo(TypeIdentification::class, 'type_identification_id', 'id');
    }
}
