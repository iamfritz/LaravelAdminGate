@extends('layouts.app')
  
@section('content')
   
    <div class="container">
        @include('sections.error')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('New Task') }}</div>
                    <div class="card-body">
                        <div class="float-end mb-2">
                            <a class="btn btn-secondary btn-sm" href="{{ route('tasks.index') }}"> Back</a>
                        </div>                        
                        <form action="{{ route('tasks.store') }}" method="POST">
                            @csrf
                        
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Title:</strong>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title">
                                    </div>
                                </div>                            
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        <textarea class="form-control" style="height:150px" name="description" placeholder="Enter Description"></textarea>
                                    </div>
                                </div>                                                            
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Level:</strong>                                     
                                    </div>
                                    <div class="form-group">
                                        <select class="form-select" aria-label="Select Task Level" name="level">
                                            <option selected>Select Task Level</option>
                                            @foreach($level as $lev)
                                                <option value="{{ $lev }}">{{ $lev }}</option>
                                            @endforeach 
                                        </select>                                          
                                    </div>                                      
                                </div>                                 
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Assign User:</strong>                                     
                                    </div>
                                    <div class="form-group">
                                        <select class="form-select" aria-label="Select User" name="assigned_to">
                                            <option selected>Select User</option>    
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} [{{ $user->email }}]</option>
                                            @endforeach                                                                            
                                        </select>                                                                              
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