<?php

namespace App\Repositories\Contracts;

interface IGroupRepository extends IModelRepository
{
    public function edit($id);
}
