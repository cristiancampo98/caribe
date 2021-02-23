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
		dd($data);
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

	public static function getPaginateAllRemissionsTrait()
	{
		return Remission::with(
							'orderDetail.order',
							'orderDetail.product',
							'creator',
							'carrier.client',
							'carrier.vehicle'
						)
						->paginate(request()->get('lenght'));
	}

    
}
