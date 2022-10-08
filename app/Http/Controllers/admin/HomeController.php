<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IHomeRepository;
use Illuminate\Http\Request;

class HomeController extends AdminBaseController
{
    public function __construct(IHomeRepository $homeRepo)
    {
        parent::__construct($homeRepo, 'admin.home');
    }
}
