<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{

	protected $modules = [
		'Clientes',
		'Productos',
		'Pedidos',
		'Remisiones',
		'Configuración'
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
			    	'name' => $value, 
			    	'slug' => $value,
			    	'available' => 1,
			    	'position' => $key + 1,
			    ],
			]);
    	}
       
    }
}
