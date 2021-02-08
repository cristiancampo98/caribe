<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeBloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
    		['O positivo','O+'],
    		['O negativo','O-'],
    		['A positivo','A+'],
    		['A negativo','A-'],
    		['B positivo','B+'],
    		['B negativo','B-'],
    		['AB positivo','AB+'],
    		['AB negativo','AB-']
    	];

    	foreach ($types as $key => $value) {
    		
	    	DB::table('type_bloods')->insert([
	    		'description' => $value[0],
	    		'acronym' => $value[1]
	    	]);
    	}
    }
}
