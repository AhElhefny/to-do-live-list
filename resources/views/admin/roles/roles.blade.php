@extends('app')
@section('title')
    Roles
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Roles','linksData' => [
        'Home'=>'dashboard',
        'Roles'=>'roles.index',
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
        @can('add role')
            <div class="mb-4">
                <button class="btn btn-primary">
                    <a class="text-light text-decoration-none" href="{{route('roles.create')}}">Add Role</a>
                </button>
            </div>
        @endcan
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <table class="table table-striped" id="roles-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Users Count</th>
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
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url :'{{route('roles.index')}}',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                },
                "paging": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'users_count', name:'users_count',
                        render:function (data){
                            return `<i class="fa fa-user mr-1"></i> ${data} `;
                        }
                    },
                    {data: 'id',
                        render:function (data,two,three){
                            if(three.id !== 1 && three.name !== 'super_admin'){
                                let form = `<form id="delete-role-form-${data}" action="roles/${data}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>`
                                let route_edit = 'roles/'+data+'/edit'
                                let delBtn = `<button class="action-buttons btn btn-danger mt-2 mb-2 delRow" id="del-${data}" data-id="${data}" >
                                    <i class="fa fa-trash"></i>
                                 </button>`;
                                return `
                                <td>
                                <div class="btn_action">
                                    @can('edit role')
                                    <a href="${route_edit}" class="action-buttons btn btn-success mt-2 mb-2">
                                        <i class="fa fa-edit" style="font-size: 16px;"></i>
                                    </a>
                                    @endcan
                                @can('delete role')${delBtn}@endcan
                                    ${form}
                                </div>
                            </td>`;
                            }
                            return 'Can not delete';
                        }
                    },
                ]
            });
        });

        $(document).on('click','.delRow',function (){
            let form = $(`#delete-role-form-${$(this).data('id')}`);
            swalDel($(this).data('id'),form);
        });
    </script>
@endsection
