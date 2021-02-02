<?php

namespace App\Traits;

use App\Models\Item;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

/**
 * 
 */
trait MenuAccessTrait
{
	public function getRolesUser(){
		return Auth::user()->roles;
	}

	public function getMenuBySlug($slug){
		return Menu::where('slug','like',$slug)
		->where('available',1)
		->first();
	}

	public function getItemBySlug($slug){
		return Item::where('route',$slug)
		->where('available',1)
		->get();
	}

    public function getAccessMenu()
    {
    	foreach ($this->getRolesUser() as $key => $value) {
    		// retorna todos los menus si tiene full access
    		if ($value['full-access'] === 'yes') {
    			return Menu::where('available',1)->with('items')->get();
    		}
    		
    		if (! empty($value->permissions)) {
    			$menu = [];
    			foreach ($value->permissions as $clave => $valor) {
    				
    				$result = $this->getMenuBySlug($valor->slug);
    				if (! empty($result)) {
    					$menu[] = $result;
    				}
    				
    			}

    			foreach ($value->permissions as $clave => $valor) {
    				foreach ($menu as $puesto => $dato) {
    					foreach ($dato->items as $key => $value) {
    						if ($value->route === $valor->slug) {
    							$submenu[] = $value;
    							$dato->items = $submenu;
    						}
    					}
    				}
    			}
    		return $menu;
    		}
    	}
    	return false;
    }
}
