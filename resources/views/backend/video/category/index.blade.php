@extends('backend.layout.master')
@section('title','Category List')
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
        <h2>Category List</h2>
        <ul class="nav navbar-right panel_toolbox">
            <a href="{{route('video.cat.create')}}" class="btn btn-outline-info btn-sm">Add Category</a>
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
                  <th>Name</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($cats as $cat)
                    <tr>
                        <td>{{$cat->name}}</td>
                        <td>
                            <span class="badge {{$cat->status == 1 ? 'badge-success' : 'badge-warning' }}">{{$cat->status == 1 ? 'Active' : 'Deactive' }}</span>
                        </td>
                        <td>{{date('d-m-Y', strtotime($cat->created_at))}}</td>
                        <td>{{($cat->updated_at == $cat->created_at) ? "N/A" : date('d-m-Y', strtotime($cat->updated_at))}}</td>
                        <td>
                            <a href="javascript:void(0)" title="View" class="btn btn-sm btn-dark data-show" data-id="{{$cat->id}}"><i class="fa fa-eye"></i></a>
                            <a href="{{route('video.cat.edit',$cat->id)}}" title="Edit" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            <a href="{{route('video.cat.delete',$cat->id)}}" title="Delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                            <a href="{{route('video.cat.status',$cat->id)}}" title="Change Status" class="btn btn-sm {{$cat->status == 1 ? 'btn-warning' : 'btn-success'}}"><i class="fa {{$cat->status == 1 ? 'fa-close' : 'fa-check'}}"></i></a>
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
            let _url = ("{{ route('video.cat.show', ['video_id']) }}");
            let __url = _url.replace('video_id', id);
            $.ajax({
                url: __url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var created_at = `{{date('m-d-Y', strtotime('${data.data.created_at}'))}}`;
                    var update = `{{date('m-d-Y', strtotime('${data.data.updated_at}'))}}`;
                    var updated_at = 'N/A';
                    if(data.data.updated_at && data.data.updated_at != data.data.created_at){
                        updated_at = update;
                    }
                    var status = `<span class="badge badge-warning">Deactive</span>`;
                     if(data.data.status == 1){
                        status = `<span class="badge badge-success">Active</span>`;
                     }
                    var data = `
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>:</th>
                            <td>${data.data.name}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <th>:</th>
                            <td>${status}</td>
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
