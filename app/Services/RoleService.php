<?php
// app/Services/RoleService.php

namespace App\Services;

use App\Models\Role;

class RoleService extends BaseService
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    // Additional methods specific to the Role model, if needed
    public function whereInField($field, $values)
    {
        return $this->model->whereIn($field, $values)->get();
    }    
}
