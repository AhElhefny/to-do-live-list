@extends('app')
@section('title')
    Add Task
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Add Task','linksData' => [
        'Home'=>'dashboard',
        'Tasks'=>'tasks.index',
    ]]])
@endsection
@section('content')
    <div>
        <form class="forms-sample" action="{{route('tasks.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{old('name')}}">
                @error('name')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" placeholder="Content"></textarea>
                @error('content')
                    <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="group_id">Group</label>
                    <select name="group_id" id="group_id" class="js-example-basic-single" style="width:100%">
                        <option disabled selected>Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                </div>
                @error('group_id')
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
