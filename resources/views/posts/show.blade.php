@extends('layouts.app')
  
@section('content')
   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Show Post') }}</div>
                    <div class="card-body">
                        <div class="float-end mb-2">
                            <a class="btn btn-secondary btn-sm" href="{{ route('posts.index') }}"> Back</a>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    {{ $post->title }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    {{ $post->description }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Category:</strong>
                                    <div>
                                        @forelse ($post->categories as $category)
                                            <span class="badge text-bg-info">{{ $category->title }}</span>
                                        @empty
                                            <span class="badge text-bg-light">No category assigned.</span>
                                        @endforelse    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection