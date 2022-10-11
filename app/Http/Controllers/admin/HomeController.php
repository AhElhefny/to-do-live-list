<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{

    public function index(){
        $roles =Role::pluck('name')->all();
        $count =[];
        foreach ($roles as $role){
            $count[$role] = User::role($role)->count();
        }
        return view('admin.home',['userRolesCount' => $count]);
    }
}
