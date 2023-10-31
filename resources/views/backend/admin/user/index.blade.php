@extends('backend.layout.master')
@section('title','User List')
@push('css_link')
<link href="{{asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('backend/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('backend/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('backend/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endpush
@section('content')

<div class="col-md-12 col-sm-12 ">
    @include('alerts.message')
    <div class="x_panel">
      <div class="x_title">
        <h2>User List</h2>
        <ul class="nav navbar-right panel_toolbox">
            <a href="{{route('user.create')}}" class="btn btn-outline-info btn-sm">Add User</a>
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
          <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Author Name</th>
              <th>Channel Name</th>
              <th>Photo</th>
              <th>Role</th>
              <th>Email</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->channel_name ?? "N/A"}}</td>
                    <td>
                        <img class="border p-1 rounded"  src="{{ asset('storage/'.$user->image)}}" height="60px" width="60px" alt="{{$user->name}}">
                    </td>
                    <td>{{$user->role}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{date('d-m-Y', strtotime($user->created_at))}}</td>
                    <td>{{($user->updated_at == $user->created_at) ? "N/A" : date('d-m-Y', strtotime($user->updated_at))}}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-sm btn-dark data-show" data-id="{{$user->id}}"><i class="fa fa-eye"></i></a>
                        <a href="{{route('user.profile',$user->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-user"></i></a>
                        <a href="{{route('user.edit',$user->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                        <a href="{{route('user.delete',$user->id)}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach

          </tbody>
        </table>
      </div>
        </div>
        </div>

        </div>
    </div>
</div>

{{-- Show By Modal --}}


<div class="modal fade bs-example-modal-lg show-modal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">

    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Show User</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto data-append">

                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>

    </div>
</div>
</div>

@endsection
@push('js_link')
    <script src="{{asset('backend/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('backend/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{asset('backend/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('backend/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('backend/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
@endpush
@push('js')
<script>
    $(document).ready(function() {
        $('.data-show').on('click', function() {
            let id = $(this).data('id');
            let _url = ("{{ route('user.show', ['id']) }}");
            let __url = _url.replace('id', id);
            $.ajax({
                url: __url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var created_at = `{{date('m-d-Y', strtotime('${data.user.created_at}'))}}`;
                    var update = `{{date('m-d-Y', strtotime('${data.user.updated_at}'))}}`;
                    var updated_at = 'N/A';
                    var image = `{{ asset("storage/".'${data.user.image}') }}`;
                    if(data.user.updated_at && data.user.updated_at != data.user.created_at){
                        updated_at = update;
                    }
                    var data = `
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>:</th>
                            <td>${data.user.name}</td>
                        </tr>
                        <tr>
                            <th>Photo</th>
                            <th>:</th>
                            <td>
                                <img src='${image}' height="60px" width="60px" class="border p-1 rounded" alt="{{$user->name}}">
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>:</th>
                            <td>${data.user.email}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <th>:</th>
                            <td>${data.user.role}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <th>:</th>
                            <td>${created_at}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <th>:</th>
                            <td>${updated_at}</td>
                        </tr>

                    </table>
                    `;
                    $('.data-append').html(data);
                    $('.show-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching member data:', error);
                }
            });
        });
    });

</script>

@endpush
