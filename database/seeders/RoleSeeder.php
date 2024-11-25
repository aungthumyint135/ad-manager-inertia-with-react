<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Owner',
            'Advertiser',
            'Publisher'
        ];

        foreach($roles as $role){
            Role::create(['name'=>$role]);
        }

        $permissions = ['user','agency','advertiser','publisher'];
        $actions = ['create','read','update','delete'];

        foreach($permissions as $permission)
        {
            foreach($actions as $action)
            {
                Permission::create(['name' => $permission.'-'.$action]);
            }
        }
    }
}
