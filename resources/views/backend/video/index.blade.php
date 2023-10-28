@extends('backend.layout.master')
@section('title','Video List')
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
            <a href="{{route('video.create')}}" class="btn btn-outline-info btn-sm">Add Video</a>
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
              <th>Title</th>
              <th>Video</th>
              <th>Thumbnail</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($videos as $video)
                <tr>
                    <td>{{$video->title}}</td>
                    <td>
                        <video src="{{ sftpLink($video->video) }}" height="60px" width="60px"></video>
                    </td>
                    <td>
                       <img src="{{ sftpLink('thumbnai/thumbnail653d6c5a64201hellow.jpg')}}" height="60px" width="60px" alt="{{$video->title}}">
                    </td>
                    <td>
                        <span class="badge {{$video->status == 1 ? 'badge-success' : 'badge-warning' }}">{{$video->status == 1 ? 'Active' : 'Deactive' }}</span>
                    </td>
                    <td>{{date('d-m-Y', strtotime($video->created_at))}}</td>
                    <td>{{($video->updated_at == $video->created_at) ? "N/A" : date('d-m-Y', strtotime($video->updated_at))}}</td>
                    <td>
                        <a href="{{route('video.show',$video->id)}}" title="View" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                        <a href="{{route('video.edit',$video->id)}}" title="Edit" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                        <a href="{{route('video.delete',$video->id)}}" title="Delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        <a href="{{route('video.status',$video->id)}}" title="Change Status" class="btn btn-sm {{$video->status == 1 ? 'btn-warning' : 'btn-success'}}"><i class="fa {{$video->status == 1 ? 'fa-close' : 'fa-check'}}"></i></a>
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

