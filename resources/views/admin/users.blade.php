@extends('app')
@section('title')
    Users
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Users','linksData' => [
        'Home'=>'home',
        'Users'=>'users.index',
    ]]])
@endsection
@section('content')
@endsection
