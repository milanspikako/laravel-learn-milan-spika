@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('All pages') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')
<!-- Custom styles for this page -->
<link href="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('All pages') }}</h1>

@include('admin.layout.partials.messages')
@if(!empty($page->id))
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">

   
    <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
     

    <li class="breadcrumb-item active" aria-current="page">{{ isset($page) ? $page->title : "" }}</li>
  </ol>
</nav>
@endif
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="rows" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        
                        <th>Active</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($rows) > 0)
                        @foreach($rows as $value)
                            <tr>
                                <td><a href="{{ route('pages.index',['page' => $value]) }}" >{{ $value->title }}</a></td>
                                <td>{{ $value->image }}</td>
                               
                                <td class="text-center text-white">
                                    @if($value->active == 1)
                                    <a href='{{ route("pages.changestatus", ["page" => $value->id]) }}' class='btn btn-sm btn-success'>{{ __('Active')}}</a>
                                    @else
                                    <a href='{{ route("pages.changestatus", ["page" => $value->id]) }}' class='btn btn-sm btn-danger'>{{ __('Inactive')}}</a>
                                    @endif
                                </td>
                                <td class="text-center text-white">
                                    <a data-placement="top" title='Edit page' href='{{ route("pages.edit", ["page" => $value->id]) }}' class="btn btn-sm btn-primary tooltip-custom">{{ __('Edit') }}</a>
                                    <a data-placement="top" title='Preview page' href='#' class="btn btn-sm btn-success tooltip-custom"><i class="fas fa-eye fa-sm fa-fw"></i></a>
                                    <a data-placement="top" title='Delete page {{ $value->title }}' data-name='{{ $value->title }}' data-toggle="modal" data-target="#deleteModal" data-href='{{ route("pages.delete", ["page" => $value->id]) }}' class="btn btn-sm btn-danger tooltip-custom">{{ __('Delete') }}</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Delete page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure that you want to delete page <span id='name-on-modal'></span>?
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
  $('#rows').DataTable({
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [1, 3] },
            { "searchable": false, "targets": [1, 2, 3] },
            { "width": "25%", "targets": [0,1,2,3] },
            
        ]
          
  });
});


$('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var name = button.data('name');
    var deleteUrl = button.data('href');
    
    $("#name-on-modal").html("<b>"+name+"</b>");
    $("#delete-button-on-modal").attr('href', deleteUrl);
});

$(function () {
  $('.tooltip-custom').tooltip()
})

</script>

@endsection

