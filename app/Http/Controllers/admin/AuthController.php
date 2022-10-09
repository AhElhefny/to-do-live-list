<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function index(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'email', 'min:4', 'max:255', Rule::exists('users', 'email')],
            'password' => ['required', 'min:6', 'max:100']
        ];

        $validator = Validator::make($request->all(),$rules);
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
        Auth::logout();
        return redirect()->route('login')->with(['success' => 'Success logged out']);
    }
}
