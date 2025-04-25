<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * Find record by id
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find(int $id, array $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Create new record
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update record by id
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    /**
     * Delete record by id
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Get first record by condition
     * @param array $condition
     * @param array $columns
     * @return mixed
     */
    public function firstWhere(array $condition, array $columns = ['*'])
    {
        return $this->model->where($condition)->first($columns);
    }

    /**
     * Get records by condition
     * @param array $condition
     * @param array $columns
     * @return mixed
     */
    public function where(array $condition, array $columns = ['*'])
    {
        return $this->model->where($condition)->get($columns);
    }

    /**
     * Get paginated records
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 15, array $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }
}
