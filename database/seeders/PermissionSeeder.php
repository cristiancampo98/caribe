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
    	$this->setPermissions('client','Clientes');
        $this->setPermissions('menu','Menús');
        $this->setPermissions('order','Pedidos');
        $this->setPermissions('permission','Permisos');
        $this->setPermissions('product','Productos');
        $this->setPermissions('remission','Remisiones');
        $this->setPermissions('role','Roles');
        $this->setPermissions('user','Usuarios');
        $this->setPermissions('vehicle','Vehículos');
        

         Permission::create([
            'name' => 'Configuración',
            'slug' => 'setting',
            'description' => 'User can show configuración',
            'controller' => 'none'
        ]);
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
