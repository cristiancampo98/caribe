<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        $this->setPermissions('role','Roles');
        $this->setPermissions('permission','Permisos');
        $this->setPermissions('menu','Menu');
        $this->setPermissions('user','Usuarios');
        $this->setPermissions('product','Productos');
        $this->setPermissions('order','Pedidos');
        $this->setPermissions('remission','Remisiones');
    }

    public function setPermissions($prefix,$nameModel){

        $prefixResource = [
            'index',
            'create',
            'edit',
            'show',
            'destroy'
        ];

        foreach ($prefixResource as $action) {
            Permission::create([
                'name' => $action . ' ' .$nameModel,
                'slug' => $prefix.'.'.$action,
                'description' => 'User can ' . $action . ' ' .$nameModel,
                'controller' => $prefix
            ]);
        }

    }
}
