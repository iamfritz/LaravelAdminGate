<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

use App\Models\Role;
use App\Services\RoleService;

class RoleController extends Controller
{
    protected $roleService;
    
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = 5;
        $data = $this->roleService->latest($paginate);
        //$data = Role::withCount('users')->latest()->paginate($paginate);
        
        return view('roles.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * $paginate);
    }
}