<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
        	[
        		'name' => 'pro 001',
        		'reference' => '001',
        		'description' => 'Generado automaticamente',
        		'cubic_meters' => 2.5,
        		'ton' => 1,
                'limit_day' => 15,
        		'user_id' => 1,
        		'status' => 1
        	],
        	[
        		'name' => 'pro 002',
        		'reference' => '002',
        		'description' => 'Generado automaticamente',
        		'cubic_meters' => 1.5,
        		'ton' => 1,
                'limit_day' => 10,
        		'user_id' => 1,
        		'status' => 1
        	]
        ]);
    }
}
