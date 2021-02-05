<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('unit_measures')->insert([
        	['name' => 'km3', 'available' => 1],
        	['name' => 'm3', 'available' => 1],
        	['name' => 'cm3', 'available' => 1],
        	['name' => 'dm3', 'available' => 1],
        	['name' => 'dam3', 'available' => 1],
        	['name' => 'mm3', 'available' => 1],
        	['name' => 'kg', 'available' => 1],
        	['name' => 'g', 'available' => 1],
        	['name' => 'mg', 'available' => 1],
        	['name' => 'ton', 'available' => 1],
        ]);
    }
}
