<?php

namespace App\Repositories\SQL;

use App\Models\Group;
use App\Models\User;
use App\Repositories\Contracts\IGroupRepository;

class GroupRepository extends AbstractModelRepository implements IGroupRepository
{
    /**
     * @param Group $model
     */
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    public function edit($id)
    {
        $group = Group::find($id);
        return ['group' => $group];
    }

}
