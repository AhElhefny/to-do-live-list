<?php

namespace App\Repositories\Contracts;

interface IAuthRepository extends IModelRepository
{

    public function login($request);

    public function logout();

}
