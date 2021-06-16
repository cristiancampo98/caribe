<?php

namespace App\Traits;

use App\Models\Menu;

/**
 * 
 */
trait MenuTrait
{
    public static function getPaginateAllMenusTrait()
    {
    	return Menu::orderBy('id','desc')->paginate( request()->get('lenght'));
    }
}
