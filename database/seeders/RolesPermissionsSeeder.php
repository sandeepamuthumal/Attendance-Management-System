<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage users',
            'manage students',
            'view students',
            'manage classes',
            'view classes',
            'scan attendance',
            'attendance report',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());

        $editor = Role::firstOrCreate(['name' => 'Teacher']);
        $editor->givePermissionTo(['view students', 'view classes','scan attendance', 'attendance report']);

        //update existing users
        $users = User::all();
        foreach ($users as $user) {
            if($user->user_types_id == 1){
                $user->assignRole('Admin');
            }
            else{
                $user->assignRole('Teacher');
            }
        }
    }
}
