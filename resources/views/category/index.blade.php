@extends('layouts.app')

 
@section('content')
<div class="container">
    
    @include('sections.message')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Categories') }}</div>

                <div class="card-body">
                    <div class="float-end mb-2">
                        <a class="btn btn-success btn-sm" href="{{ route('category.create') }}"> Create New Category</a>
                    </div>                  
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Posts</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $value->title }}</td>
                            <td>{{ $value->posts_count }}</td>
                            <td class="text-center">
                                <form action="{{ route('category.destroy',$value->id) }}" method="POST" class="delete-form">   
                                    <a class="btn btn-info btn-sm" href="{{ route('category.show',$value->id) }}">Show</a>    
                                    <a class="btn btn-primary btn-sm" href="{{ route('category.edit',$value->id) }}">Edit</a>   
                                    @csrf
                                    @method('DELETE')      
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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