<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Services\HelperTrait;

class UserController extends AdminBaseController
{
    use HelperTrait;
    protected IUserRepository $userRepo;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(IUserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        parent::__construct($userRepo, 'admin.users.users');
    }

    public function create(){
        if (!$this->authorize('add user'))
            abort(405);
        $roles = Role::all();
        return view('admin.users.add',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request){
        $data =$request->validated();
        $data['userPhoto'] = $request->file('userPhoto') ?
            $this->storeImage($request->file('userPhoto'),User::$folder) : null;

        $user = $this->userRepo->create($data);
        $user->assignRole($request->input('role_id'));
        return redirect()->route('users.index');
    }

    public function edit($id){
        if (!$this->authorize('edit role'))
            abort(405);
        $data = $this->userRepo->edit($id);
        $roles = $data['roles'];
        $user = $data['user'];
        return view('admin.users.edit',compact('roles','user'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if($request->file('userPhoto')){
            $data['userPhoto'] = $this->storeImage($request->file('userPhoto'),User::$folder);
        }
        $user = $this->userRepo->update($user,$data);
        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        $user->assignRole($request->input('role_id'));
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->userRepo->deleteUserImageIfExist($user);
        $this->userRepo->remove($user);
        return back()->with(['success' => 'User deleted successfully']);
    }
}
