<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.test',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        $user->syncRoles($role);

        $module_permissions = [
            'Instructor' => [
                'Access',
                'Create',
                'Edit',
                'Delete',
            ],
            'Subject' => [
                'Access',
                'Create',
                'Edit',
                'Delete',
            ],
            'Questionnaire' => [
                'Access',
                'Create',
                'Edit',
                'Delete',
            ],
            'Scheduling' => [
                'Access',
                'Create',
                'Edit',
                'Delete',
            ],
            'Student' => [
                'Access',
                'Create',
                'Edit',
                'Delete',
            ],
            'Class' => [
                'Access',
                'Create',
                'Edit',
                'Delete',
            ],
        ];

        foreach($module_permissions as $module => $permissions) {
            foreach($permissions as $permission) {
                $name = str_replace(' ','_',(strtolower($module))) . '.' . str_replace(' ','_',(strtolower($permission)));

                Permission::create([
                    'name' => $name
                ]);
            }
        }
    }
}
