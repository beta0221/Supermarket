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
        $employee->email = 'employee@employee.com';
        $employee->password = 'employee';
        $employee->birthday = '1995-03-13';
        $employee->gender = 1;
        $employee->save();
        $employee->roles()->attach($role_employee);

        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@admin.com';
        $admin->password = 'admin';
        $admin->birthday = '1995-02-21';
        $admin->gender = 1;
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
