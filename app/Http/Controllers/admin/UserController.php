<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Http\Request;

class UserController extends AdminBaseController
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(IUserRepository $userRepo)
    {
        parent::__construct($userRepo, 'admin.users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

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
    public function update(Request $request, User $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

    }
}
