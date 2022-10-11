@extends('app')
@section('title')
    Add User
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Add User','linksData' => [
        'Home'=>'dashboard',
        'Users'=>'users.index',
    ]]])
@endsection
@section('content')
    <div>
        <form class="forms-sample" action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{old('name')}}">
                @error('name')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}">
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
                <label for="user-photo">Photo</label>
                <input type="file" name="userPhoto" class="form-control" id="user-photo" >
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
                            <option value="{{$role->id}}">{{$role->name}}</option>
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
