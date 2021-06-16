<?php

namespace App\Traits\Consignment\Store;

use App\Traits\MultimediaTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait StoreConsignmentTrait 
{
	use MultimediaTrait;

	public static function StoreConsignmentFromOrder($data, $order_id, $file)
	{
		$consignment_id = DB::table('consignments')->insertGetId([
    		'consignment_number' => $data['consignment']['consignment_number'],
    		'fully_apply' => 1,
    		'order_id' => $order_id,
    		'created_by' => Auth::id(),
    		'created_at' => Carbon::now('America/Bogota'),
    		'updated_at' => Carbon::now('America/Bogota'),
    	]);

    	if ($file) {
    		self::storeSingleFileMultimedia(
    			$file['imagen'], 
                'consignments', 
                'consignment', 
                'consignment_file', 
                'consignment_id', 
                $consignment_id
    		);
    	}
    	
    	return $consignment_id;
	}

}