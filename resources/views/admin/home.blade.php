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
    <div class="row">
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5><i class="fa fa-user text-primary ml-auto mr-2"></i>Users</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0">{{\App\Models\User::count()}}</h2>
                            </div>
                            @foreach($userRolesCount as $key=>$userRole)
                                <h6 class="text-muted font-weight-normal d-flex justify-content-between"><span>{{preg_replace('/[^A-Za-z0-9\-]/', ' ', strtoupper($key))}}</span><span class="badge badge-primary">{{$userRole}}</span></h6>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
