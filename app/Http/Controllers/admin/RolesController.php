<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Repositories\Contracts\IRoleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;


class RolesController extends Controller
{
    protected IRoleRepository $rolesRepo;
    public function __construct(IRoleRepository $rolesRepo)
    {
        $this->rolesRepo = $rolesRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (!$this->authorize('roles'))
            abort(405);
        if (\request()->ajax()){
            $data = Role::select('id','name')->get();
            return Datatables::of($data)->make(true);
        }
        return view('admin.roles.roles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        if (!$this->authorize('add role'))
            abort(405);
        $permissions = Permission::all();
        return view('admin.roles.add',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        if (!$this->authorize('add role'))
            abort(405);
        $this->rolesRepo->store($request);
        return redirect()->route('roles.index')->with('success','Role added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        if (!$this->authorize('edit role'))
            abort(405);
        $data = $this->rolesRepo->edit($id);
        $role = $data['role'];
        $permissions = $data['permissions'];
        $rolePermissions = $data['rolePermissions'];
        return view('admin.roles.edit',compact('role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRequest $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, $id)
    {
        if (!$this->authorize('edit role'))
            abort(405);
        $this->rolesRepo->update($request,$id);
        return redirect()->route('roles.index')->with('success','Role updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        if (!$this->authorize('delete role'))
            abort(405);
        $this->rolesRepo->destroy($id);
        return redirect()->back()->with('success','Role deleted successfully');
    }
}
