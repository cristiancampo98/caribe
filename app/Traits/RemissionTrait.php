<?php

namespace App\Traits;

use App\Models\Remission;
use App\Traits\MultimediaTrait;
use Illuminate\Support\Facades\Auth;

/**
 * 
 */
trait RemissionTrait
{
	use MultimediaTrait;

	public static function storeRemission($data)
	{
		$remission = (new Remission)->fill($data->all());
		$remission->created_by = Auth::id();
		$remission->save();
		
		if ($data->hasFile('firm')) {
			self::storeSingleFileMultimedia(
				$data->file('firm'),
				'remission',
				'remission',
				'remission_firm',
				'remission_id',
				$remission->id
			);
		}

		return $remission;
	}

    
}
