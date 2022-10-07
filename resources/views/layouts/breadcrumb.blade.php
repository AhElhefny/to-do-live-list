<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{$links['title']}}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            @if($links['linksData'])
                @foreach($links['linksData'] as $key => $value)
                    <li class="breadcrumb-item"><a href="{{route($value)}}">{{$key}}</a></li>
                @endforeach
            @endif
        </ol>
    </div>
</div>
