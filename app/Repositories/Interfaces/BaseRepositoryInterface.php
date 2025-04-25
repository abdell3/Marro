<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * Get all records
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    /**
     * Find record by id
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find(int $id, array $columns = ['*']);

    /**
     * Create new record
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update record by id
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * Delete record by id
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Get first record by condition
     * @param array $condition
     * @param array $columns
     * @return mixed
     */
    public function firstWhere(array $condition, array $columns = ['*']);

    /**
     * Get records by condition
     * @param array $condition
     * @param array $columns
     * @return mixed
     */
    public function where(array $condition, array $columns = ['*']);

    /**
     * Get paginated records
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 15, array $columns = ['*']);
}
