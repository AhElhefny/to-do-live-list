@extends('app')
@section('title')
    Community Groups
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Community Groups','linksData' => [
        'Home'=>'dashboard',
        'Groups'=>'groups.index',
    ]]])
@endsection
@section('content')
    <div>
        <div class="row grid-margin stretch-card">
            @foreach($groups as $group)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img class="card-img-top" style="height: 150px;" src="{{$group->image}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{$group->name}}</h5>
                            <span class="badge badge-outline-primary mb-2"><i class="fa fa-user"></i> {{strtoupper($group->user_name_text)}}</span>
                            <p class="card-text">{{$group->description}}</p>
                            <div class="text-center">
                                <div class="d-flex justify-content-center mb-2" style="gap: 3px">
                                    <span class="col-3 comunity-group-span">Type</span>
                                    <span class="col-3 comunity-group-span">Status</span>
                                    <span class="col-3 comunity-group-span">Blocked</span>
                                    <span class="col-3 comunity-group-span">Reason</span>
                                </div>
                                <div class="d-flex justify-content-center" style="gap: 3px">
                                    <span class="col-3 badge badge-outline-primary comunity-group-span-row">{{$group->type_text}}</span>
                                    <span class="col-3 badge badge-outline-primary comunity-group-span-row">{{$group->status_text}}</span>
                                    <span class="col-3 badge badge-outline-primary comunity-group-span-row">{{$group->blocked == 0 ? 'No' :'Yes'}}</span>
                                    <span class="col-3 badge badge-outline-primary comunity-group-span-row">
                                        {{($group->blocked == 0 ? 'Un-Blocked' : ($group->block_description ?? 'No-Reason'))}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{$groups->links()}}

    </div>
@endsection
@section('scripts')

@endsection

