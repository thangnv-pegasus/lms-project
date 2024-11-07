<?php

namespace App\Repositories;

use App\Helpers\Constant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository
{
    protected $model;

    protected $primaryKey;

    protected $msgNotFound = 'Data not found';

    public function __construct()
    {
        $this->setModel();
        $this->setPrimaryKey();
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel(): void
    {
        $this->model = app()->make($this->getModel());
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function setPrimaryKey(): void
    {
        $this->primaryKey = $this->model->getKeyName();
    }

    public function getObject($id): ?Model
    {
        try {
            if ($id instanceof $this->model) {
                $result = $id;
            } else {
                $result = $this->model->findOrFail($id);
            }

            return $result;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function getMany(array $ids): Collection
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->get();
    }

    public function filters($conditions, $returnEntity = false)
    {
        if (empty($conditions['select'])) {
            $selectable = $this->model->selectable ?? ['*'];
        } else {
            $selectable = $conditions['select'];
        }

        $entities = $this->model->select($selectable);

        // relations
        if (isset($conditions['with'])) {
            $entities = $entities->with($conditions['with']);
        }

        // relations
        if (isset($conditions['join'])) {
            foreach ($conditions['join'] as $join) {
                $entities = $entities->join($join['table'], $join['inside'], '=', $join['outside']);
                if (isset($join['conditions'])) {
                    foreach ($join['conditions'] as $field => $value) {
                        $entities = $entities->where($field, $value);
                    }
                }
            }
        }

        // whereHas
        if (isset($conditions['whereHas'])) {
            if (is_array($conditions['whereHas'])) {
                foreach ($conditions['whereHas'] as $item) {
                    if (is_array($item)) {
                        $entities = $entities->where(function ($query) use ($item) {
                            $index = 0;
                            foreach ($item as $field => $value) {
                                if ($index) {
                                    if (is_int($field)) {
                                        $query->orWhereHas($value);
                                    } else {
                                        $query->orWhere($field, $value);
                                    }
                                } else {
                                    $query->whereHas($value);
                                }
                                $index++;
                            }
                        });
                    } else {
                        $entities = $entities->whereHas($item);
                    }
                }
            } else {
                $entities = $entities->whereHas($conditions['whereHas']);
            }

        }

        // filter
        foreach ($conditions as $column => $value) {
            $entities = $value ? $this->search($entities, $column, $value) : $entities;
        }

        // first
        if (isset($conditions['first'])) {
            return $entities->first();
        }

        // Order by
        $sortBy = isset($conditions['sort_by']) ? $conditions['sort_by'] : 'id';
        if (isset($conditions['sort_option'])) {
            $entities = $entities->orderBy($sortBy, $conditions['sort_option']);
        } else {
            $entities = $entities->orderBy($sortBy, 'desc');
        }

        // limit
        if (isset($conditions['per_page'])) {
            return $entities->paginate($conditions['per_page']);
        }

        return $returnEntity ? $entities : $entities->get();
    }

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
                return $query->where($column, $data);
            default:
                return $query;
        }
    }

    public function exists($id): bool
    {
        return $this->model->where($this->model->getKeyName(), $id)->exists();
    }

    public function findOrFail($id): ?Model
    {
        try {
            $result = $this->model->findOrFail($id);
        } catch (\Exception $e) {
            throw new ModelNotFoundException($this->msgNotFound, 0);
        }

        return $result;
    }

    public function insertMany($params)
    {
        foreach ($params as $key => $param) {
            $params[$key] = $this->updateTimestamp($param);
        }

        return DB::table($this->model->getTable())->insert($params);
    }

    public function update($id, array $attribute): bool
    {
        $object = $this->getObject($id);
        if ($object) {
            return $object->update($attribute);
        }

        return false;
    }

    public function delete(array $ids): bool
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->delete();
    }

    protected function updateTimestamp($data, $columns = ['created_at', 'updated_at'])
    {
        $now = date(Constant::FORMAT_DATETIME);
        if ($this->queryBuilderTimestamp) {
            foreach ($columns as $column) {
                $data[$column] = $now;
            }
        }

        return $data;
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }
}
