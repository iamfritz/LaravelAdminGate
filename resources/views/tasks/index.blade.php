@extends('layouts.app')

 
@section('content')
<div class="container">
    
    @include('sections.message')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Tasks') }}</div>

                <div class="card-body">
                    <div class="float-end mb-2">
                        <a class="btn btn-success btn-sm" href="{{ route('tasks.create') }}"> Create New Task</a>
                    </div>                  
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th>No</th>
                            <th>Task</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Assign User</th>
                            <th>Author</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($data as $key => $task)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $task->title }}</td>
                            <td><span class="badge level-{{ $task->level }}">{{ $task->level }}</span></td>
                            <td><span class="badge status-{{ $task->status }}">{{ $task->status }}</span></td>
                            <td>{{ $task->assignedUser->name }}</td>
                            <td>{{ $task->author->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" class="delete-form">   
                                    <a class="btn btn-info btn-sm" href="{{ route('tasks.show',$task->id) }}">Show</a>    
                                    <a class="btn btn-primary btn-sm" href="{{ route('tasks.edit',$task->id) }}">Edit</a>   
                                    @csrf
                                    @method('DELETE')      
                                    <button type="submit" class="btn btn-danger btn-sm delete-button" onclickxx="return confirm('Are you sure you want to delete this item')">Delete</button>
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