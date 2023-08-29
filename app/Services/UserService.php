<?php
// app/Services/UserService.php

namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    // Additional methods specific to the User model, if needed
    public function latest($paginate)
    {
        return $this->model->latest()->paginate($paginate);
    }    
}
