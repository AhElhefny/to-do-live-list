@extends('app')
@section('title')
    Edit User
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Edit User','linksData' => [
        'Home'=>'dashboard',
        'Users'=>'users.index',
    ]]])
@endsection
@section('content')
    <div>
        <form class="forms-sample" action="{{route('users.update',$user->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{$user->id}}">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{$user->name}}">
                @error('name')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}">
                @error('email')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                @error('password')
                <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Password confirmation</label>
                <input type="password" class="form-control" id="confirmation-password" name="password confirmation" placeholder="confirmation-Password">
                @error('password confirmation')
                <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Photo</label>
                <input type="file" class="form-control" id="user-photo" name="userPhoto">
                @error('userPhoto')
                <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role_id" id="role" class="js-example-basic-single" style="width:100%">
                        <option disabled selected>Select Role</option>
                        @foreach($roles as $role)
                            <option @if($user->role_id === $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                @error('role_id')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
        </form>

    </div>
@endsection
