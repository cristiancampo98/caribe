<?php

namespace App\Traits\Remission\Query;

use App\Models\Remission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait QueryRemissionTrait {

	public static function getRemissionById($id)
	{
		return Remission::find($id);
	}

	public static function getRemissionByProductTrait($id)
	{
		return Remission::whereDate('created_at', Carbon::today())
		->whereHas('orderDetail', function (Builder $query) use ($id) {
		    $query->where('product_id', $id);
		})
		->get()
		->sum('delivered');
	}

	public static function getTotalDeliveredByDetail($detail_id)
	{
		return Remission::where('order_details_id', $detail_id)
		->get()
		->sum('delivered');
	}
}