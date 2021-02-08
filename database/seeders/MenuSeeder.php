<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{

	protected $modules = [
		['Clientes', 'client.index', 1],
		['Productos', 'product.index', 1],
		['Pedidos', 'order.index', 1],
		['Remisiones', 'remission.index', 1],
		['Configuración', 'setting', 0]
	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach ($this->modules as $key => $value) {
    		 DB::table('menus')->insert([
			    [
			    	'name' => $value[0], 
			    	'slug' => $value[1],
			    	'available' => 1,
			    	'position' => $key + 1,
			    	'isDirect' => $value[2]
			    ],
			]);
    	}
       
    }
}
