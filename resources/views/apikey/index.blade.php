@extends('layouts.app')

 
@section('content')
<div class="container">

    @include('sections.message')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('API Keys') }}</div>

                <div class="card-body">
                    @can('admin')
                    <div class="float-end mb-2">
                        <a class="btn btn-success btn-sm" href="{{ route('apikey.create') }}">Generate API Key</a>
                    </div>
                    @endcan
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th>No</th>
                            <th>API Keys</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $value->key }}</td>
                            <td class="text-center">
                                @can('admin')
                                <form action="{{ route('apikey.destroy',$value->id) }}" method="POST">                                       
                                    @csrf
                                    @method('DELETE')      
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item')">Delete</button>
                                </form>
                                @endcan
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