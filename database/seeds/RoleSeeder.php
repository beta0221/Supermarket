<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>'Admin']);
        Role::create(['name'=>'Employee']);
        Role::create(['name'=>'Vip']);

        $permission_read = Permission::where('name','Read')->first();
        $permission_write = Permission::where('name','Write')->first();
        $roles = Role::all();
        foreach($roles as $role){
            if($role->name == 'Admin'){
                $role->permissions()->save($permission_read);
                $role->permissions()->save($permission_write);
            }
            else if($role->name == 'Employee'){
                $role->permissions()->save($permission_read);
            }
        }        
    }
}
