<?php

namespace App\Repositories\Contracts;

interface IUserRepository extends IModelRepository
{

    public function edit($id);

}
