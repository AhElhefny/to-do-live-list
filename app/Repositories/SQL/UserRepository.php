<?php

namespace App\Repositories\SQL;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;

class UserRepository extends AbstractModelRepository implements IUserRepository
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
