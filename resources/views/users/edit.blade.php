@extends('layouts.app')
  
@section('content')
   
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit User') }}</div>
                    <div class="card-body">
                        <div class="float-end mb-2">
                            <a class="btn btn-secondary btn-sm" href="{{ route('users.index') }}"> Back</a>
                        </div>                        
                        <form action="{{ route('users.update',$user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                    
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Email Address:</strong>
                                        <input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="Enter Email" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Password:</strong>
                                        <input type="password" name="password" class="form-control" placeholder="Password" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Roles:</strong>                                     
                                    </div>
                                    <div class="form-group">                                        

                                        @foreach($roles as $role)
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                    @if($user->roles->pluck('id')->contains($role->id)) checked @endif
                                                > {{ $role->name }}
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