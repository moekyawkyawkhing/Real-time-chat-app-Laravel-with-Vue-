@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url('chat') }}" class="btn btn-success btn-md rounded-0">Go to chatting room</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
