<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
        		'name' => 'Super admin', 
        		'email' => 'superadmin@caribe.com', 
        		'password' => Hash::make('!Caribe_2020*sa')
        	],
        	[
        		'name' => 'Admin', 
        		'email' => 'admin@caribe.com', 
        		'password' => Hash::make('!Caribe_2020*a')
        	],
        	[
        		'name' => 'Client', 
        		'email' => 'client@caribe.com', 
        		'password' => Hash::make('!Caribe_2020*c')
        	],
        ]);
    }
}
