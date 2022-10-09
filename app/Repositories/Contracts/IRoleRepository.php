<?php

namespace App\Repositories\Contracts;

interface IRoleRepository
{
    public function store($request);
    public function edit($id);
    public function update($request,$id);
    public function destroy($id);
}
