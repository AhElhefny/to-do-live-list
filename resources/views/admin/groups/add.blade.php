@extends('app')
@section('title')
    Add Group
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Add Group','linksData' => [
        'Home'=>'dashboard',
        'Groups'=>'groups.index',
    ]]])
@endsection
@section('content')
    <div>
        <form class="forms-sample" action="{{route('groups.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{old('name')}}">
                @error('name')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                @error('description')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="js-example-basic-single" style="width:100%">
                        <option disabled selected>Select Type</option>
                        @foreach(group_types() as $group)
                            <option value="{{$group['id']}}">{{$group['name']}}</option>
                        @endforeach
                    </select>
                </div>
                @error('type')
                <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="js-example-basic-single" style="width:100%">
                        <option disabled selected>Select Type</option>
                        @foreach(group_status() as $status)
                            <option value="{{$status['id']}}">{{$status['name']}}</option>
                        @endforeach
                    </select>
                </div>
                @error('status')
                <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" id="image" >
                @error('image')
                <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
        </form>

    </div>
@endsection
