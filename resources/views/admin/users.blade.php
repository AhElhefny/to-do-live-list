@extends('app')
@section('title')
    Users
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Users','linksData' => [
        'Home'=>'dashboard',
        'Users'=>'users.index',
    ]]])
@endsection
@section('content')
@endsection
