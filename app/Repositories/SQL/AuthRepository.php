<?php

namespace App\Repositories\SQL;

use App\Models\User;
use App\Repositories\Contracts\IAuthRepository;
use App\Repositories\Contracts\IUserRepository;

class AuthRepository extends AbstractModelRepository implements IAuthRepository
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

}
