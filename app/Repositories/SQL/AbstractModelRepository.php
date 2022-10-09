<?php

namespace App\Repositories\SQL;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\IModelRepository;

abstract class AbstractModelRepository implements IModelRepository
{
    protected $defaultFilters = [];

    /**
     * @var Model
     */
    protected $model;

    protected $query;

    /**
     * AbstractModelRepository constructor.
     *
     * @param $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $model->query();
    }

    public function isFieldsDirty(Model $model, $inputs, $fields = [])
    {
        $inputs = $this->cleanUpAttributes($inputs);

        if (empty($fields)) {
            foreach ($inputs as $key => $value) {
                if ($model->$key != $value) {
                    return true;
                }
            }
        } else {
            foreach ($fields as $field) {
                if ($model->$field != $inputs[$field]) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isRelationDirty(
        Model $model,
              $relationName,
              $newRelationIDs,
              $value = 'id',
              $key = null
    )
    {
        if ($key) {
            $oldRelationIDs = $model->$relationName->mapWithKeys(function ($item, $index) use ($key, $value) {
                return [$index => [data_get($item, $key) => data_get($item, $value)]];
            })->all();
        } else {
            $relation = $model->$relationName;
            if ($relation instanceof Collection) {
                $oldRelationIDs = $relation->pluck($value)->all();
            } else {
                $oldRelationIDs = [$relation->$value];
            }
        }

        if (count($oldRelationIDs) != count($newRelationIDs)) {
            return true;
        }

        if (!empty(array_diff_multi($oldRelationIDs, $newRelationIDs))) {
            return true;
        }

        return false;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function updateAll($attributes = [])
    {
        if (!empty($attributes)) {
            // Clean the attributes from unnecessary inputs
            $filterd = $this->cleanUpAttributes($attributes);

            return $this->model->query()->update($filterd);
        }
        return false;
    }

    protected function cleanUpAttributes($attributes)
    {
        return collect($attributes)->filter(function ($value, $key) {
            return $this->model->isFillable($key);
        })->toArray();
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function createOrUpdate($attributes = [], $id = null)
    {
        if (empty($attributes)) {
            return false;
        }

        // Clean the attributes from unnecessary inputs
        $filterd = $this->cleanUpAttributes($attributes);

        if ($id) {
            $model = $this->model->find($id);
            return $this->update($model, $filterd);
        }

        return $this->create($filterd);
    }

    /**
     * @param Model $model
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(Model $model, $attributes = [])
    {
        if (!empty($attributes)) {
            // Clean the attributes from unnecessary inputs
            $filterd = $this->cleanUpAttributes($attributes);
            return tap($model)->update($filterd)->fresh();
        }

        return false;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = [])
    {
        if (!empty($attributes)) {
            // Clean the attributes from unnecessary inputs
            $filterd = $this->cleanUpAttributes($attributes);

            return $this->model->create($filterd);
        }

        return false;
    }

    public function createMany($data = [])
    {
        if (!empty($data)) {
            return $this->model->insert($data);
        }

        return false;
    }

    /**
     * @param array $searchIn
     * @param array $attributes
     * @return mixed
     */
    public function UpdateOrCreate(array $searchIn = [], array $attributes = [])
    {
        $model = $this->model->updateOrCreate($searchIn, $attributes);

        return $model;
    }

    /**
     * @param Model $model
     *
     * @return mixed
     */
    public function remove(Model $model)
    {
        // Check if model has relations
        foreach ($model->getDefinedRelations(true) as $relation) {
            if ($model->$relation()->exists()) {
                throw new \Exception("Can't delete, model has related records");
            }
        }

        return $model->delete();
    }

    public function attach($model,$relation, $data)
    {
        return $model->{$relation}()->attach($data);
    }

    public function sync($model,$relation, $data)
    {
        return $model->{$relation}()->sync($data);
    }

    public function detach($model,$relation, $data = null)
    {
        return $model->{$relation}()->detach($data);
    }

    public function count()
    {
        return $this->query->count();
    }

    public function first()
    {
        return $this->query->first();
    }

    public function exists()
    {
        return $this->query->exists();
    }

    public function doesntExist()
    {
        return $this->query->doesntExist();
    }

    public function increment(Model $model,$column,$value)
    {
        $model->increment($column,$value);
    }

    public function decrement(Model $model,$column,$value)
    {
        $model->decrement($column,$value);
    }

    public function sum($column)
    {
        return $this->aggregate('sum',$column);
    }

    public function aggregate($function,$column)
    {
        return $this->query->{$function}($column);
    }

//    public function withoutGlobalScope($scope)
//    {
//        $this->query->withGlobalScope($scope);
//        return $this;
//    }

    public function findOrFail($id)
    {
        return $this->query->findOrFail($id);
    }

    public function findIds($ids)
    {
        return $this->query->findOrFail($ids);
    }

    /**
     * @param int $id
     * @param array $relations
     *
     * @return mixed
     */
    public function find(int $id, array $relations = [])
    {
        $query = $this->model;
        if (!empty($relations)) {
            $query = $query->with($relations);
        }

        return $query->find($id);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function findBy($key, $value)
    {
        return $this->model->where($key, $value)/*->dump()*/ ->first();
    }

    /**
     * @param mixed $fields
     *
     * @return mixed
     */
    public function findByFields(array $fields)
    {
        $query = $this->model;

        if (isset($fields['and'])) {
            $query = $query->where($fields['and']);
        }

        if (isset($fields['or'])) {
            $query = $query->orWhere(function (Builder $query) use ($fields) {
                foreach ($fields['or'] as $condition) {
                    $query = $query->orWhere($condition[0], $condition[1]);
                }
            });
        }

        if (!isset($fields['and']) && isset($fields['or'])) {
            $query = $query->where($fields);
        }

        /* foreach ($fields as $key => $value) {
            $query = $query->where($key, $value);
        } */

        return $query->first();
    }

    public function findAllByFields(array $fields)
    {
        $query = $this->model;

        if (isset($fields['and'])) {
            $query = $query->where($fields['and']);
        }

        if (isset($fields['or'])) {
            $query = $query->orWhere(function (Builder $query) use ($fields) {
                foreach ($fields['or'] as $condition) {
                    $query = $query->orWhere($condition[0], $condition[1]);
                }
            });
        }

        if (!isset($fields['and']) && isset($fields['or'])) {
            $query = $query->where($fields);
        }

        /* foreach ($fields as $key => $value) {
            $query = $query->where($key, $value);
        } */

        return $query->get();
    }

    public function whereOrCreate(array $attributes, array $values = [])
    {
        $query = $this->model;

        return $query->firstOrCreate($attributes, $values);
    }

    /**
     * @param string $labelField
     * @param string $valueField
     *
     * @return mixed
     */
    public function findAllForFormSelect(
        $labelField = null,
        $valueField = 'id',
        $applyOrder = false,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR
    )
    {
        $query = $this->model;

        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }

        return $query->pluck($valueField, $labelField);
    }

    /**
     * @param boolean $applyOrder
     * @param string $orderByBookMov
     * @param string $orderDir
     *
     * @return mixed
     */
    public function findAll($fields = ['*'], $applyOrder = true, $orderBy = self::ORDER_BY, $orderDir = self::ORDER_DIR)
    {
        $query = $this->model;
        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }

        return $query->get($fields);
    }

    /**
     * @param array $filters
     * @param array $relations
     * @param bool $applyOrder
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @param array $extraOrderBy
     * @param array $extraOrderDir
     * @return mixed
     */
    public function search(
        $filters = [],
        $relations = [],
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR,
        $extraOrderBy = self::EXTRA_ORDER_BY,
        $extraOrderDir = self::EXTRA_ORDER_DIR
    )
    {
        $query = $this->model;

        if (!empty($relations)) {
            $query = $query->with($relations);
        }


        // Merge default filters with requested filters
        $filters = array_merge($this->defaultFilters, $filters);
        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }

        return $this->getQueryResult(
            $query,
            $applyOrder,
            $page,
            $limit,
            $orderBy,
            $orderDir,
            $extraOrderBy,
            $extraOrderDir
        );
    }

    /**
     * @param            $query
     * @param bool $applyOrder
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @param array $extraOrderBy
     * @param array $extraOrderDir
     * @return mixed
     */
    public function getQueryResult(
        $query,
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR,
        $extraOrderBy = self::EXTRA_ORDER_BY,
        $extraOrderDir = self::EXTRA_ORDER_DIR
    )
    {
        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }

        if ($extraOrderBy) {
            for ($i = 0; $i < count($extraOrderBy); $i++) {
                $dir = $extraOrderDir[$i] ? $extraOrderDir[$i] : self::ORDER_DIR;
                $query = $query->orderBy($extraOrderBy[$i], $dir);
            }
        }

        if ($page) {
            return $query->take($limit)->skip(0)->get();
        }

        if ($limit) {
            return $query->take($limit)->get();
        }

        return $query->get();
    }

    /**
     * @param            $query
     * @param bool $applyOrder
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @param array $extraOrderBy
     * @param array $extraOrderDir
     * @return mixed
     */
    public function getResults(
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR,
        $extraOrderBy = self::EXTRA_ORDER_BY,
        $extraOrderDir = self::EXTRA_ORDER_DIR
    )
    {
        if ($applyOrder) {
            $this->query->orderBy($orderBy, $orderDir);
        }

        if ($extraOrderBy) {
            for ($i = 0; $i < count($extraOrderBy); $i++) {
                $dir = $extraOrderDir[$i] ? $extraOrderDir[$i] : self::ORDER_DIR;
                $this->query->orderBy($extraOrderBy[$i], $dir);
            }
        }
//        info ($this->query->toSql());
        if (config('app.query_debug')) {
            return $this->query->toSql();
        }

        if ($page) {
            return $this->query->paginate($limit);
        }

        if ($limit) {
            return $this->query->take($limit)->get();
        }

        return $this->query->get();
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function searchCount(
        $filters = []
    )
    {
        $query = $this->model;

        // Merge default filters with requested filters
        $filters = array_merge($this->defaultFilters, $filters);
        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }
        return $query->count();
    }

    /**
     * @param array $filters
     * @return AbstractModelRepository
     */
    public function searchQuery(
        array $filters = []
    ): AbstractModelRepository
    {
        // Merge default filters with requested filters
        $filters = array_merge($this->defaultFilters, $filters);
        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $this->query->$withFilter($filters[$filter]);
                }
            }
        }
        return $this;
    }


    /**
     * @param array $relations
     * @return AbstractModelRepository
     */
    public function with(
        $relations = []
    )
    {
        foreach ($relations as $relation) {
            $this->query->with($relation);
        }
        return $this;
    }

    /**
     * @param array $relations
     * @return AbstractModelRepository
     */
    public function has(
        array $relations = []
    )
    {
        foreach ($relations as $relation) {
            $this->query->has($relation);
        }
        return $this;
    }

    /**
     * @param array $relations
     * @return AbstractModelRepository
     */
    public function doesntHave(
        array $relations = []
    ): AbstractModelRepository
    {
        foreach ($relations as $relation) {
            $this->query->has($relation);
        }
        return $this;
    }

    public function havingRaw($sql): AbstractModelRepository
    {
        $this->query->havingRaw($sql);
        return $this;
    }

    /**
     * @param array $relations
     * @return AbstractModelRepository
     */
    public function whereHas($relations = [])
    {
        foreach ($relations as $relationName => $filters) {
//            info($relationName);
            if (!method_exists($this->model, $relationName))
            {
//                info("no relation");
                return $this;
            }
            $this->query->whereHas($relationName, function ($query) use ($relationName, $filters) {
                if (!empty($filters)) {
//                    info($filters);
                    $relatedModel = $this->getRelatedModel($relationName);
                    if (!$relatedModel)
                    {
//                        info("no model");
                        return $this;
                    }
                    foreach ($relatedModel->getFilters() as $filter) {
//                        info($filter);
                        if (isset($filters[$filter])) {
                            $withFilter = "of" . ucfirst($filter);
                            $query->$withFilter($filters[$filter]);
                        }
                    }
                }
            });
        }
        return $this;
    }

    /**
     * @param array $columns
     * example : invoices.amount [relation.column]
     * @return AbstractModelRepository
     */
    public function withSum(
        $columns = []
    )
    {
        foreach ($columns as $column) {
            $split = explode('.', $column);
            if (count($split) == 2) {
                $this->query->withSum($split[0], $split[1]);
            }
        }
        return $this;
    }

    /**
     * @param array $relations
     * @return AbstractModelRepository
     */
    public function withCount(
        $relations = []
    )
    {
        foreach ($relations as $relation) {
            $this->query->withCount($relation);
        }
        return $this;
    }

    /**
     * @param array $filters
     * @param array $relations
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function searchBySelected(
        $groupBy = null,
        $fields = [],
        $filters = [],
        $relations = [],
        $applyOrder = false,
        $page = false,
        $limit = false,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR
    )
    {
        $query = $this->model;

        if (!empty($relations)) {
            $query = $query->with($relations);
        }

        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                //if (isset($filters[$filter]) and !empty($filters[$filter])) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }

        if (!empty($fields)) {
            $query = $query->selectRaw(implode(',', $fields));
        }

        if (!empty($groupBy)) {
            $query = $query->groupBy(implode(',', $groupBy));
        }

        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }

        if ($page) {
            return $query->paginate($limit);
        }

        if ($limit) {
            return $query->take($limit)->get();
        }

        return $query->get();
    }

    /**
     * Create a Pagination From Items Of  array Or collection.
     *
     * @param array|Collection $items
     * @param int $perPage
     * @param int $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public static function getConstants($keyContains = null, $returnCount = false)
    {
        // Get all constants
        $model = app(get_called_class())->model;
        $constants = (new \ReflectionClass($model))->getConstants();
        // Return filtered constants based on constants names filter
        if (!empty($keyContains)) {
            $constants = array_filter($constants, function ($k) use ($keyContains) {
                return strpos($k, $keyContains) === 0;
            }, ARRAY_FILTER_USE_KEY);
        }

        if ($returnCount) {
            return count($constants);
        }

        return $constants;
    }

    /**
     * @param key
     *
     * @return mixed
     */
    public function last()
    {
        return $this->model->latest()->first();
    }

    /**
     * @param $scope
     * @return $this
     */
    public function withoutGlobalScope($scope)
    {
        return new $this($this->model::withoutGlobalScope($scope));
    }

    public function model()
    {
        return $this->model;
    }

    public function tableName()
    {
        return $this->model()->getTable();
    }

    private function getRelatedModel($relationName)
    {
        $className = get_class($this->model->{$relationName}()->getRelated());
        return app($className);
    }

    public function all()
    {
        return $this->model->all();
    }
}
