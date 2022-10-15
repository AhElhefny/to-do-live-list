@extends('app')
@section('title')
    Edit Group
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Edit Group','linksData' => [
        'Home'=>'dashboard',
        'Groups'=>'groups.index',
    ]]])
@endsection
@section('content')
    <div>
        <form class="forms-sample" action="{{route('groups.update',$group->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{$group->id}}">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{$group->name}}">
                @error('name')
                <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description">{{$group->description}}</textarea>
                @error('description')
                <span style="font-size: 14px;" class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="js-example-basic-single" style="width:100%">
                        <option disabled selected>Select Type</option>
                        @foreach(group_types() as $groupLoop)
                            <option @if($groupLoop['id'] == $group->type) selected @endif value="{{$groupLoop['id']}}">{{$groupLoop['name']}}</option>
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
                        @foreach(group_status() as $statusLoop)
                            <option @if($statusLoop['id'] == $group->status) selected @endif value="{{$statusLoop['id']}}">{{$statusLoop['name']}}</option>
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
