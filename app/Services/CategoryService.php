<?php
// app/Services/CategoryService.php

namespace App\Services;

use App\Models\Category;

class CategoryService extends BaseService
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    // Additional methods specific to the Category model, if needed
    public function findwithPostCount($id)
    {
        return $this->model->withCount('posts')->find($id);
    }

    public function latestwithPostCount($paginate)
    {
        return $this->model->latest()->withCount('posts')->paginate($paginate);
    }

}
