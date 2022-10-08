<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IAuthRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends AdminBaseController
{
    public function __construct(IAuthRepository $authRepo)
    {
        parent::__construct($authRepo, 'admin.auth.login');
    }

    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => ['required', 'email', 'min:4', 'max:255', Rule::exist('users', 'email')],
                'password' => ['required', 'min:6', 'max:100']
            ]);

            $remember = $request->rememberMe ? true : false;
            if (!auth()->attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
                return back()->withInput(['email' => $request->email]);
            }
            session()->regenerate();
            return redirect()->route('')->with(['msg' => 'U R Logged in successfully']);
        } catch (\Exception $ex) {
            return back()->withInput(['email' => $request->email])->withErrors($ex);
        }
    }
}
