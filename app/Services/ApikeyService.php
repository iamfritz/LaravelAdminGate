<?php
// app/Services/ApikeyService.php

namespace App\Services;

use App\Models\Apikey;

class ApikeyService extends BaseService
{
    public function __construct(Apikey $model)
    {
        parent::__construct($model);
    }

    // Additional methods specific to the Apikey model, if needed
    public function generate()
    {
        return $this->model->withCount('posts')->find($id);
    }
}
