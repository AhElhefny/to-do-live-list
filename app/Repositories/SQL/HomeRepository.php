<?php

namespace App\Repositories\SQL;

use App\Models\Home;
use App\Models\User;
use App\Repositories\Contracts\IHomeRepository;

class HomeRepository extends AbstractModelRepository implements IHomeRepository
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
