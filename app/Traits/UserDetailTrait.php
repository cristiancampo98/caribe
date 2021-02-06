<?php

namespace App\Traits;

use App\Models\UserDetail;

/**
 * 
 */
trait UserDetailTrait
{
	public static function storeUserDetail($data,$id)
	{
		return UserDetail::updateOrCreate(
			[
				'user_id' => $id
			],
			[
				"number_identification" => $data['number_identification'],
				"type_identification" => $data['type_identification'],
				"sex" => $data['sex'],
				"type_blood" => $data['type_blood'],
				"name_company" => $data['name_company'],
				"type_pay" => $data['type_pay'],
				"street_address" => $data['street_address'],
				"street_details" => $data['street_details'],
				"street_comune" => $data['street_comune'],
				"city" => $data['city'],
				"deparment" => $data['deparment'],
				"country" => $data['country'],
				"others_email" => $data['others_email'],
				"phones" => $data['phones'],
			]
		);

	}
   
}
