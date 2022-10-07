<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IAuthRepository;
use Illuminate\Http\Request;

class AuthController extends AdminBaseController
{
    public function __construct(IAuthRepository $authRepo)
    {
        parent::__construct($authRepo, 'auth.login');
    }

    public function login(){
        dd(7);
    }
}
