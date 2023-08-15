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
                        @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>
                                @forelse ($value->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @empty
                                    <li>No roles assigned.</li>
                                @endforelse                                  
                            </td>
                            <td class="text-center">
                                <form action="{{ route('users.destroy',$value->id) }}" method="POST">   
                                    <a class="btn btn-info btn-sm" href="{{ route('users.show',$value->id) }}">Show</a>
                                    @can('admin')
                                        <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$value->id) }}">Edit</a>   
                                        @csrf
                                        @method('DELETE')      
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item')">Delete</button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>  
                    <div class="mt-5">{!! $data->links() !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection