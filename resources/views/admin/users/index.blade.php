@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('All admin users') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')
<!-- Custom styles for this page -->
<link href="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('All admin users') }}</h1>

@include('admin.layout.partials.messages')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="users" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Active</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users) > 0)
                        @foreach($users as $value)
                            <tr>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->email }}</td>
                                <td class="text-center text-white">
                                    @if($value->active == 1)
                                    <a href='{{ route("users.changestatus", ["user" => $value->id]) }}' class='btn btn-sm btn-success'>{{ __('Active')}}</a>
                                    @else
                                    <a href='{{ route("users.changestatus", ["user" => $value->id]) }}' class='btn btn-sm btn-danger'>{{ __('Inactive')}}</a>
                                    @endif
                                </td>
                                <td>{{ $value->phone }}</td>
                                <td>{{ $value->address }}</td>
                                <td>{{ ucfirst($value->role) }}</td>
                                <td class="text-center text-white">
                                    <a data-placement="top" title='Edit user' href='{{ route("users.edit", ["user" => $value->id]) }}' class="btn btn-sm btn-primary tooltip-custom">{{ __('Edit') }}</a>
                                    <a data-placement="top" title='Change password' href='{{ route("users.changepassword", ["user" => $value->id]) }}' class="btn btn-sm btn-success tooltip-custom"><i class="fas fa-lock fa-sm fa-fw"></i></a>
                                    <a data-placement="top" title='Delete user {{ $value->name }}' data-name='{{ $value->name }}' data-toggle="modal" data-target="#deleteModal" data-href='{{ route("users.delete", ["user" => $value->id]) }}' class="btn btn-sm btn-danger tooltip-custom">{{ __('Delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure that you want to delete user <span id='name-on-modal'>Pera</span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a id='delete-button-on-modal' type="button" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<!-- Page level plugins -->
<script src="/admin/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#users').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": [6] },
            { "searchable": false, "targets": [6] }
        ]
  });
});


$('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var userName = button.data('name');
    var userDeleteUrl = button.data('href');
    
    $("#name-on-modal").html("<b>"+userName+"</b>");
    $("#delete-button-on-modal").attr('href', userDeleteUrl);
});

$(function () {
  $('.tooltip-custom').tooltip()
})

</script>

@endsection

