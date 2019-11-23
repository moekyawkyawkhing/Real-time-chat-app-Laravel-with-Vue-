@extends('layouts.app')
@section('content')
<div id="app">
    <chat :user="{{ auth()->user() }}"></chat>
</div>
@endsection