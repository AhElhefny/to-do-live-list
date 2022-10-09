@extends('app')
@section('title')
    Users
@endsection
@section('breadcrumb')
    @include('layouts.breadcrumb',['links' => ['title' => 'Users','linksData' => [
        'Home'=>'dashboard',
        'Users'=>'users.index',
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
                    <a class="text-light text-decoration-none" href="{{route('users.create')}}">Add User</a>
                </button>
            </div>
        @endcan
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div>
                        <table class="table table-striped" id="users-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
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
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url :'/api/v1/users',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                },
                "paging": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'id',
                        render:function (data,two,three){
                            if(three.id !== 1 && three.name !== 'admin'){
                                let form = `<form id="delete-role-form-${data}" action="users/${data}" method="POST">
                                    @csrf
                                @method('DELETE')
                                </form>`
                                let route_edit = 'users/'+data+'/edit'
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
            swalDel($(this).data('id'));
        });
        function swalDel(id){
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((result) => {
                if (result.isConfirmed){
                    $('#delete-role-form-'+id).submit();
                } else {
                    Swal.fire("Cancelled", "canceled successfully!", "error");
                }
            })
        }
    </script>
@endsection
