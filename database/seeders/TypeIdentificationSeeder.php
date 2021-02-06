<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeIdentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types = [
    		['Registro civil','RC'],
    		['Tarjeta de identidad','TI'],
    		['Cédula de ciudadanía','CC'],
    		['Cédula de extranjería','CE'],
    	];
    	foreach ($types as $key => $value) {
    		
	    	DB::table('type_identifications')->insert([
	    		'description' => $value[0],
	    		'acronym' => $value[1]
	    	]);
    	}
        
    }
}
