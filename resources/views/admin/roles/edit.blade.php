@extends('app')
@section('title')
    Edit Role
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Edit Role','linksData' => [
        'Home'=>'dashboard',
        'Roles'=>'roles.index',
    ]]])
@endsection
@section('content')
    <div>
        <form class="forms-sample" action="{{route('roles.update',$role->id)}}" method="POST">
            @csrF
            @method('PATCH')
            <div class="form-group">
                <input type="hidden" name="id" value="{{$role->id}}">
                <label for="name">Role Name</label>
                <input type="text" class="form-control" name="name" placeholder="Role Name" value="{{$role->name}}">
                @error('name')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group row">
                        <strong>Permissions:</strong>
                        @foreach($permissions as $value)
                            <div class="form-check col-md-2">
                                <label class="form-check-label">
                                    <input @if(in_array($value->id,$rolePermissions)) checked @endif type="checkbox" class="form-check-input" name="permission[]" value="{{$value->id}}">
                                    {{$value->name}}
                                </label>
                            </div>
                        @endforeach
                        @error('permission')
                        <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
        </form>
    </div>
@endsection
