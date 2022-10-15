@extends('app')
@section('title')
    Groups
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Groups','linksData' => [
        'Home'=>'dashboard',
        'Groups'=>'groups.index',
    ]]])
@endsection
@section('content')
    <div>
        @if(\Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{\Session::get('success')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @can('add groups')
            <div class="mb-4">
                <button class="btn btn-primary">
                    <a class="text-light text-decoration-none" href="{{route('groups.create')}}">Add Group</a>
                </button>
            </div>
        @endcan
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div>
                        <table class="table table-striped" id="groups-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Blocked</th>
                                <th>Block Reason</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#groups-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url :"{{route('groups.index')}}",
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                },
                "paging": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'type_text', name: 'type_text'},
                    {data: 'status_text', name: 'status_text'},
                    {data: 'blocked', name: 'blocked',
                        render:function (data) {
                            return data == 0 ? `<span class="badge badge-success">No</span>` :
                                `<span class="badge badge-danger">Yes</span>`;
                        }
                    },
                    {data: 'block_description', name: 'block_description',
                        render:function (data,two,three) {
                        if(three['blocked'] == 0){
                            return `<span class="badge badge-success">Un-Blocked</span>`;
                        }
                            return data ?? 'No-Reason';
                        }
                    },
                    {data: 'image', name: 'image',
                        render:function (data) {
                            return `<img style="width: 30px;height: 30px;" src="${data}" alt="group-image"/>`
                        }
                    },
                    {data: 'created_at', name: 'created_at'},
                    {data: 'id',
                        render:function (data,two,three){
                                let form = `<form id="delete-group-form-${data}" action="groups/${data}" method="POST">
                                    @csrf
                                @method('DELETE')
                                </form>`
                                let route_edit = 'groups/'+data+'/edit'
                                let delBtn = `<button class="action-buttons btn btn-danger mt-2 mb-2 delRow" id="del-${data}" data-id="${data}" >
                                    <i class="fa fa-trash"></i>
                                 </button>`;
                                return `
                                <td>
                                <div class="btn_action">
                                    @can('edit groups')
                                <a href="${route_edit}" class="action-buttons btn btn-success mt-2 mb-2">
                                        <i class="fa fa-edit" style="font-size: 16px;"></i>
                                    </a>
                                    @endcan
                                @can('delete groups')${delBtn}@endcan
                                ${form}
                                </div>
                            </td>`;
                        }
                    },
                ]
            });
        });

        $(document).on('click','.delRow',function (){
            let form = $(`#delete-group-form-${$(this).data('id')}`)
            swalDel($(this).data('id'),form);
        });
    </script>
@endsection

