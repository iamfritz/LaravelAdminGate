@extends('layouts.app')

 
@section('content')
<div class="container">

    @include('sections.message')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Roles') }}</div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th>No</th>
                            <th>API Keys</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $value->name }}</td>
                            <td class="text-center">
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