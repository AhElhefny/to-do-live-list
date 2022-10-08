<?php

namespace App\Repositories\SQL;

use App\Models\User;
use App\Repositories\Contracts\IAuthRepository;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthRepository extends AbstractModelRepository implements IAuthRepository
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function login($request)
    {
            $rules = [
                'email' => ['required', 'email', 'min:4', 'max:255', Rule::exists('users', 'email')],
                'password' => ['required', 'min:6', 'max:100']
            ];

            $validator = Validator::make($request,$rules);
            return $validator;
    }

    public function logout(){
        Auth::logout();
    }

}
