@extends('layouts.app')
  
@section('content')
   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Show User') }}</div>
                    <div class="card-body">
                        <div class="float-end mb-2">
                            <a class="btn btn-secondary btn-sm" href="{{ route('users.index') }}"> Back</a>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {{ $user->name }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email Address:</strong>
                                    {{ $user->email }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Roles:</strong>
                                    @forelse ($user->roles as $role)
                                        <span class="badge text-bg-info">{{ $role->title }}</span>
                                    @empty
                                        <span class="badge text-bg-light">No role assigned.</span>
                                    @endforelse                                       
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection