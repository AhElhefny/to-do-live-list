<?php

namespace App\Http\Controllers;
use App\Repositories\Contracts\IModelRepository;

class AdminBaseController extends Controller
{

    protected $repo;

    protected $view;

    protected $relations = [];

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(IModelRepository $repo, $view) {
        ini_set('memory_limit', '2048M');
        $this->repo = $repo;
        $this->view = $view;

        // Include embedded data
        if (request()->has('embed')) {
            $this->parseIncludes(request('embed'));
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $page = 1;
        $limit = 0;
        $order = 'id';
        $applyOrder = false;
        $orderDir = "desc";
        $extraOrderBy = [];
        $extraOrderDir = [];

        $filters = request()->all();

        if (request()->has('applyOrder')) {
            $applyOrder = request('applyOrder');
        }

        if (request()->has('page')) {
            $page = request('page');
        }

        if (request()->has('limit')) {
            $limit = request('limit');
        }

        if (request()->has('order')) {
            $order = request('order');
        }

        if (request()->has('orderDir')) {
            $orderDir = request('orderDir');
        }

        if (request()->has('extraOrderBy')) {
            $extraOrderBy = request('extraOrderBy');
        }

        if (request()->has('extraOrderDir')) {
            $extraOrderDir = request('extraOrderDir');
        }

        $models = $this->repo->search(
            $filters,
            $this->relations,
            $applyOrder,
            $page,
            $limit,
            $order,
            $orderDir,
            $extraOrderBy,
            $extraOrderDir
        );

        return $this->respondWithCollection($models);
    }

    protected function parseIncludes($embed)
    {
        $this->relations = explode(',', $embed);
    }


    /**
     * @param $collection
     * @param array $headers
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function respondWithCollection($collection, array $headers = [])
    {
        $data = $collection;
        return view($this->view,compact('data'));
    }

}
