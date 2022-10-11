<?php

namespace App\Repositories\SQL;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRepository extends AbstractModelRepository implements IUserRepository
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        return ['roles' => $roles,'user' => $user];
    }

    public function deleteUserImageIfExist($user){
        $flag = false;
        if($user->userPhoto != $user->folder . '/' .$user->default_avatar &&
            Storage::disk('siteImages')->exists($user->userPhoto)){
            $flag = unlink(public_path('images/'. $user->userPhoto));
        }
        return $flag;
    }
}
