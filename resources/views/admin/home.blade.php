@extends('app')
@section('title')
    Home
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Home','linksData' => [
        'Home'=>'dashboard',
    ]]])
@endsection
@section('content')
@endsection
