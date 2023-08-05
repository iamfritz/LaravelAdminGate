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
                <div class="card-header">{{ __('Post') }}</div>

                <div class="card-body">
                    <div class="float-end mb-2">
                        <a class="btn btn-success btn-sm" href="{{ route('posts.create') }}"> Create New Post</a>
                    </div>                  
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $value->user->name }}</td>
                            <td>{{ $value->title }}</td>
                            <td>{{ \Str::limit($value->description, 100) }}</td>
                            <td class="text-center">
                                <form action="{{ route('posts.destroy',$value->id) }}" method="POST">   
                                    <a class="btn btn-info btn-sm" href="{{ route('posts.show',$value->id) }}">Show</a>    
                                    <a class="btn btn-primary btn-sm" href="{{ route('posts.edit',$value->id) }}">Edit</a>   
                                    @csrf
                                    @method('DELETE')      
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>  
                    {!! $data->links() !!}      
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection