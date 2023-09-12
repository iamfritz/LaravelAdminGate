<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Services\UserService;
use App\Services\RoleService;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $userService;
    protected $roleService;
    protected $apiData;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        //$this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
        $this->userService = $userService;
        $this->roleService = $roleService;        
        $this->apiData = [
                    "status"    => "error",
                    "message"   => "",
                    "data"      => [] 
                ];        
    }

    public function me(Request $request)
    {   
        $user = Auth::user();

        $this->apiData["status"] = "success"; 
        $this->apiData["data"] = $user; 

        return response()->json($this->apiData);           
    }

    public function refreshToken()
    {
        $user = Auth::user(); 
        $user->tokens()->delete();
        
        $newToken = $user->createToken('auth_token')->plainTextToken;

        $this->apiData["status"] = "success"; 
        $this->apiData["message"] = 'Refresh Token'; 
        $this->apiData["data"] = [
                                    'user' => $user,
                                    'authorization' => [
                                        'token' => $newToken,
                                        'type' => 'bearer',
                                    ]
                                ]; 

        return response()->json($this->apiData);           
    }
        
    public function login(AuthRequest $request)
    {

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $this->apiData["status"] = "success"; 
            $this->apiData["message"] = 'Login Completed'; 
            $this->apiData["data"] = [
                                        'user' => $user,
                                        'authorization' => [
                                            'token' => $user->createToken('ApiToken')->plainTextToken,
                                            'type' => 'bearer',
                                        ]
                                    ]; 

            return response()->json($this->apiData);            
        }

        $this->apiData["message"] = 'Invalid credentials';         
        return response()->json($this->apiData);
    }

    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $this->apiData['errors'] = $validator->errors(); //422
            return response()->json($this->apiData);
        }        

        $userData = $request->only(['name', 'email', 'password']);
        $userData['password'] = Hash::make($request->input('password'));
        $user = $this->userService->create($userData);

        
        $inputRoles    = ['user'];
        $roles = $this->roleService->whereInField('id', $inputRoles);        
        // Assign the role to the user
        $user->roles()->sync($roles);

        $this->apiData["status"] = "success"; 
        $this->apiData["message"] = 'Registration Completed'; 
        $this->apiData["data"] = $user; 

        return response()->json($this->apiData);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        $this->apiData["status"] = "success";
        $this->apiData["message"] = 'Successfully logged out';         
        
        return response()->json($this->apiData);        
    }
}
