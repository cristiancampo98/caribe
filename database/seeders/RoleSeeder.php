<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
		    [
		    	'name' => 'Super Administrador', 
		    	'slug' => 'super.root',
		    	'description' => 'El todo poderoso',
		    	'full-access' => 'yes',
		    	'public' => 1,
		    ],
		    [
		    	'name' => 'Administrador', 
		    	'slug' => 'root',
		    	'description' => 'Acceso a funciones básicas',
		    	'full-access' => 'no',
		    	'public' => 1,
		    ],
		    [
		    	'name' => 'Cliente', 
		    	'slug' => 'client',
		    	'description' => 'Acceso a pedidos',
		    	'full-access' => 'no',
		    	'public' => 1,
		    ],
		    [
		    	'name' => 'Secretaria', 
		    	'slug' => 'secretary',
		    	'description' => 'Pedidos y remisiones',
		    	'full-access' => 'no',
		    	'public' => 1,
		    ],
		    [
		    	'name' => 'Asistente', 
		    	'slug' => 'assistant',
		    	'description' => 'remisiones',
		    	'full-access' => 'no',
		    	'public' => 1,
		    ],
		    [
		    	'name' => 'Contador', 
		    	'slug' => 'accounter',
		    	'description' => 'Reportes',
		    	'full-access' => 'no',
		    	'public' => 1,
		    ]
		]);
    }
}
