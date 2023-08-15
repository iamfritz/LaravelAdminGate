@extends('layouts.app')

 
@section('content')
<div class="container">

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    <div class="float-end mb-2">
                        <a class="btn btn-success btn-sm" href="{{ route('users.create') }}"> Create New User</a>
                    </div>                  
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse ($user->roles as $role)
                                    <span class="badge text-bg-success">{{ $role->name }}</span>
                                @empty
                                    <span class="badge text-bg-light">No role assigned.</span>
                                @endforelse                                  
                            </td>
                            <td class="text-center">
                                <form action="{{ route('users.destroy',$user->id) }}" method="POST">   
                                    <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}">Show</a>
                                    @can('admin')
                                        <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}">Edit</a>   
                                        @csrf
                                        @method('DELETE')      
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item')">Delete</button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>  
                    <div class="mt-5">
                        <div class="custom-pagination">
                            {{ $users->links('pagination.custom') }}
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection