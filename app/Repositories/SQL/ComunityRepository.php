<?php

namespace App\Repositories\SQL;

use App\Models\Task;
use App\Repositories\Contracts\IComunityRepository;

class ComunityRepository extends AbstractModelRepository implements IComunityRepository
{
    /**
     * @param Task $model
     */
    public function __construct($model)
    {
        parent::__construct($model);
    }

}
