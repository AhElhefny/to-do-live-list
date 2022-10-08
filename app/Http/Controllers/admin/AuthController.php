<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IAuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends AdminBaseController
{
    protected $authRepo;
    public function __construct(IAuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
        parent::__construct($authRepo, 'auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $validator = $this->authRepo->login($data);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        if (!auth()->attempt($validator->validated())) {
            return back()->with(['error' => 'Your email or password are invalid']);
        }
        session()->regenerate();
        return redirect()->route('dashboard')->with(['success' => 'Logged in successfully']);
    }

    public function destroy(){
        $this->authRepo->logout();
        return redirect()->route('login')->with(['success' => 'Success logged out']);
    }
}
