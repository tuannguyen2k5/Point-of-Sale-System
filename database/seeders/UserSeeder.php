<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        $this->call([
            RoleTableSeeder::class,
        ]);
        $role_employee = Role::where('name', 'employee')->first();
        $role_manager  = Role::where('name', 'admin')->first();
        $role_saler = Role::where('name', 'saler')->first();

        $employee = new User();
        $employee->name = 'Employee Name';
        $employee->username = 'Employee Username';
        $employee->email = 'employee@example.com';
        $employee->password = '123456';
        $employee->active = '1';
        $employee->save();
        $employee->roles()->attach($role_employee);

        $saler = new User();
        $saler->name = 'Saler Name';
        $saler->username = 'Saler Username';
        $saler->email = 'saler@example.com';
        $saler->password = '123456';
        $saler->active = '1';
        $saler->save();
        $saler->roles()->attach($role_saler);

        $manager = new User();
        $manager->name = 'Admin Name';
        $manager->username = 'Admin Username';
        $manager->email = 'admin@example.com';
        $manager->password = '123456';
        $manager->active = '1';
        $manager->save();
        $manager->roles()->attach($role_manager);
    }
}
