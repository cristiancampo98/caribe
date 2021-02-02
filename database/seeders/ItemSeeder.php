<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
	protected $items = [
		 ['Roles','role.index'],
		['Permisos','permission.index'],
		['Menu','menu.index'],
		['Usuarios','user.index']
	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->items as $value) {
    		 DB::table('items')->insert([
			    [
			    	'name' => $value[0], 
			    	'route' => $value[1],
			    	'available' => 1,
			    	'menu_id' => 5
			    ],
			]);
    	}
    }
}
