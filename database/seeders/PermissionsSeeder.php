<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('role_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();
        $permissions = [
            ['guard_name' => 'web' , 'name' => 'users'],
            ['guard_name' => 'web' , 'name' => 'add user'],
            ['guard_name' => 'web' , 'name' => 'edit user'],
            ['guard_name' => 'web' , 'name' => 'show user'],
            ['guard_name' => 'web' , 'name' => 'delete user'],
            ['guard_name' => 'web' , 'name' => 'roles'],
            ['guard_name' => 'web' , 'name' => 'add role'],
            ['guard_name' => 'web' , 'name' => 'edit role'],
            ['guard_name' => 'web' , 'name' => 'show role'],
            ['guard_name' => 'web' , 'name' => 'delete role'],
            ['guard_name' => 'web' , 'name' => 'groups'],
            ['guard_name' => 'web' , 'name' => 'add groups'],
            ['guard_name' => 'web' , 'name' => 'edit groups'],
            ['guard_name' => 'web' , 'name' => 'show groups'],
            ['guard_name' => 'web' , 'name' => 'delete groups'],
            ['guard_name' => 'web' , 'name' => 'tasks'],
            ['guard_name' => 'web' , 'name' => 'add tasks'],
            ['guard_name' => 'web' , 'name' => 'edit tasks'],
            ['guard_name' => 'web' , 'name' => 'show tasks'],
            ['guard_name' => 'web' , 'name' => 'delete tasks'],
        ];
        $role = Role::create([
            'name' => 'super_admin'
        ]);
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);
        Permission::insert($permissions);
        $role->syncPermissions(Permission::all());
        $user->assignRole($role);

    }
}
