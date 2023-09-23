<?php
// app/Services/TaskService.php

namespace App\Services;

use App\Models\Task;

class TaskService extends BaseService
{
    protected $taskService;
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }    

    public function latestWithUsers($paginate)
    {
        return $this->model->with('assignedUser')->latest()->paginate($paginate);
    }    
}
