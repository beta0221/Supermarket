<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin  = Role::where('name', 'Admin')->first();
        $role_employee = Role::where('name', 'Employee')->first();

        $employee = new User();
        $employee->name = 'employee';
        $employee->email = 'employee@employee';
        $employee->password = 'employee';
        $employee->save();
        $employee->roles()->attach($role_employee);

        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@admin';
        $admin->password = 'admin';
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
