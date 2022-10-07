<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface IModelRepository
{
    const LIMIT = 10;
    const ORDER_BY = 'id';
    const ORDER_DIR = 'DESC';
    const EXTRA_ORDER_BY = [];
    const EXTRA_ORDER_DIR = [];

    public function isFieldsDirty(Model $model, $inputs, $fields = []);

    public function isRelationDirty(
        Model $model,
        $relationName,
        $newRelationIDs,
        $value = 'id',
        $key = null
    );

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * @param Model $model
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(Model $model, $attributes = []);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function updateAll($attributes = []);

    /**
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function createOrUpdate($attributes = [], $id = null);

    /**
     * @param array $searchIn
     * @param array $attributes
     * @return mixed
     */
    public function UpdateOrCreate(array $searchIn = [], array $attributes = []);

    /**
     * @param Model $model
     *
     * @return mixed
     */
    public function remove(Model $model);

    /**
     * @param int $id
     * @param array $relations
     *
     * @return mixed
     */
    public function find(int $id, array $relations = []);

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function findBy($key, $value);

    /**
     * @param mixed $fields
     *
     * @return mixed
     */
    public function findByFields(array $fields);

    /**
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function whereOrCreate(array $attributes, array $values = []);

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
    );

    /**
     * @param boolean $applyOrder
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function findAll($fields = [], $applyOrder = true, $orderBy = self::ORDER_BY, $orderDir = self::ORDER_DIR);

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
    public function search(
        $filters = [],
        $relations = [],
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR
    );

    /**
     * @param array $filters
     * @return mixed
     */
    public function searchCount(
        $filters = []
    );

    /**
     * @param            $query
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function getQueryResult(
        $query,
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR
    );

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
    public function paginate($items, $perPage = 15, $page = null, $options = []);

    public static function getConstants($keyContains = null, $returnCount = false);

    public function withoutGlobalScope($scope);

    public function model();

    public function tableName();
}
