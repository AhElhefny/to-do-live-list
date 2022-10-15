<?php

namespace App\Repositories\Contracts;

interface ITaskRepository extends IModelRepository
{
    public function edit($id);
}
