<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuAccessController extends Controller
{
	protected $menu;

	public function __construct(){
		$this->menu = new Menu;

	}
    public function getAccessMenu(){
    	return $this->menu->getAccessMenu();
    }
}
