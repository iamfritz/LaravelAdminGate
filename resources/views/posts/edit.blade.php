@extends('layouts.app')
  
@section('content')
   
    <div class="container">
        @include('sections.error')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Post') }}</div>
                    <div class="card-body">
                        <div class="float-end mb-2">
                            <a class="btn btn-secondary btn-sm" href="{{ route('posts.index') }}"> Back</a>
                        </div>                        
                        <form action="{{ route('posts.update',$post->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                    
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Title:</strong>
                                        <input type="text" name="title" value="{{ $post->title }}" class="form-control" placeholder="Title">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        <textarea class="form-control" style="height:150px" name="description" placeholder="Detail">{{ $post->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Categories:</strong>                                     
                                    </div>
                                    <div class="form-group">
                                        @foreach($categories as $category)
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'checked' : '' }} /> {{ $category->title }}
                                                </label>
                                            </div>                                            
                                        @endforeach                                        
                                    </div>                                    
                                </div>                                 
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection