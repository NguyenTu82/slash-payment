<?php

namespace App\Repositories;

use App\Repositories\Interfaces\Builder;
use App\Repositories\Interfaces\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function all();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Get one
     * @return mixed
     */
    public function first();

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Show
     * @param $id
     * @return mixed
     */
    public function show($id);

    /**
     * Get query
     * @return Builder
     */
    public function getQuery();

    /**
     * Clear query
     * @return \Illuminate\Database\Query\Builder
     */
    public function clearQuery();

    /**
     * File all
     * @param array $filter
     * @return mixed
     */
    public function findBy(array $filter);

    /**
     * Find one
     * @param array $filter
     * @return mixed
     */
    public function findOneBy(array $filter);

    /**
     * paginate
     * @param $page
     * @return LengthAwarePaginator|mixed
     */
    public function paginate($page);
}
