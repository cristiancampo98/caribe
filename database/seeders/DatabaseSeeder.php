<?php

namespace Database\Seeders;

use Database\Seeders\ItemSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
	        UserSeeder::class,
	        MenuSeeder::class,
	        ItemSeeder::class,
	        RoleSeeder::class,
	        PermissionSeeder::class,
	        RoleUserSeeder::class
	    ]);
    }
}
