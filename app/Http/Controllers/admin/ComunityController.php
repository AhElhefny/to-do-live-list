<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IGroupRepository;

class ComunityController extends Controller
{
    public $groupRepo;
    public function __construct(IGroupRepository $groupRepo)
    {
        $this->groupRepo = $groupRepo;
    }

    public function groups(){
        $groups = $this->groupRepo->search(['block'=>0,'status'=>1],['user'],true,false,6);
        return view('admin.comunity.groups',compact('groups'));
    }
}
