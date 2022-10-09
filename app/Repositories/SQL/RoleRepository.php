<?php

namespace App\Repositories\SQL;

use App\Repositories\Contracts\IRoleRepository;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository implements IRoleRepository
{

    public function store($request){
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->input('permission'));
    }

    public function edit($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return ['role' => $role,'permissions' => $permissions,'rolePermissions' => $rolePermissions];
    }

    public function update($request,$id)
    {
        $role = Role::findById($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->input('permission'));
    }

    public function destroy($id)
    {
        DB::table('roles')->where('id',$id)->delete();
        DB::table('role_has_permissions')->where('role_id',$id)->delete();
    }

}
