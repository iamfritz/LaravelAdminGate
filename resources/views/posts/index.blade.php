@extends('layouts.app')

 
@section('content')
<div class="container">

    @include('sections.message')

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
                        @foreach ($posts as $key => $post)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->title }}</td>
                            <td>
                                @forelse ($post->categories as $category)
                                    <span class="badge text-bg-info">{{ $category->title }}</span>
                                @empty
                                    <span class="badge text-bg-light">No category assigned.</span>
                                @endforelse                                   
                            </td>
                            <td>{{ \Str::limit($post->description, 100) }}</td>
                            <td class="text-center">
                                <form action="{{ route('posts.destroy',$post->id) }}" method="POST">   
                                    <a class="btn btn-info btn-sm" href="{{ route('posts.show',$post->id) }}">Show</a>    
                                    <a class="btn btn-primary btn-sm" href="{{ route('posts.edit',$post->id) }}">Edit</a>   
                                    @csrf
                                    @method('DELETE')      
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>  
                    <div class="mt-5">{!! $posts->links() !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection