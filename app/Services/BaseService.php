<?php
// app/Services/BaseService.php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data)
    {
        $model->update($data);

        return $model;
    }

    public function delete(Model $model)
    {
        $model->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }
    public function latest($paginate)
    {
        return $this->model->latest()->paginate($paginate);
    }    
}
