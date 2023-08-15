<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        if(auth()->check()){
            $user = auth()->user();
        }        
        return view('home',compact('user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::latest()->paginate(5);
        return view('users.index',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('admin')) {
            abort(403, "You don't have permission to access.");
        }

        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('admin')) {
            abort(403, "You don't have permission to access.");
        }

         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'roles' => 'required|array'
        ]);

        
        $user = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        
        $inputRoles    = $request->input('roles');
        $roles = Role::whereIn('id', $inputRoles)->get();

        // Assign the role to the user
        $user->roles()->sync($roles);


        return redirect()->route('users.index')
                        ->with('success','User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));              
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {       
        if (Gate::denies('admin')) {
            abort(403, "You don't have permission to access.");
        }
        $roles = Role::all();
        return view('users.edit',compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Gate::denies('admin')) {
            abort(403, "You don't have permission to access.");
        }
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', 'min:8'],
            'roles' => 'required|array'
        ]);
        
        $postData       = array(); 
        $postData['name']     = $request->input('name');
        $postData['email']    = $request->input('email');
        
        if($request->input('password')){
            $postData['password'] = Hash::make($request->input('password'));
        }
                
        $user->update($postData);

        $inputRoles    = $request->input('roles');
        $roles = Role::whereIn('id', $inputRoles)->get();

        // Assign the role to the user
        $user->roles()->sync($roles);        
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Gate::denies('admin')) {
            abort(403, "You don't have permission to access.");
        }
        $user->delete();
                    
            return redirect()->route('users.index')
                            ->with('success','User deleted successfully');
    
    }
}