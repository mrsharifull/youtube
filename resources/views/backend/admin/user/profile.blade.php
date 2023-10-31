@extends('backend.layout.master')
@section('title','User Profile')
@section('content')

<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>User Profile</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>User Information</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a href="{{route('user.edit',$data->id)}}"><i class="fa fa-edit"></i></a>
              </li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-3 col-sm-3  profile_left">
              <div class="profile_img">
                <div id="crop-avatar">
                  <!-- Current avatar -->
                  <img class="img-responsive avatar-view img-fluid" style="border-radius: 5px; padding:10px; border: 1px solid gray;" src="{{$data->image ? storage_link($data->image) : asset('no_img.jpg')}}" alt="{{$data->name}}" title="{{$data->name." Profile Photo"}}">
                </div>
              </div>
              <h3>{{$data->name}}</h3>

              <ul class="list-unstyled user_data">
                <li>
                    <i class="fa fa-tv user-profile-icon"></i>
                    @if(!empty($data->channel_name))
                    {{$data->channel_name}}
                    @else
                    <a href="{{route('user.edit',$data->id)}}" class="btn btn-sm btn-outline-secondary">Create Channel Name</a>
                    @endif
                </li>
                <li><i class="fa fa-envelope user-profile-icon"></i> {{$data->email}}
                </li>
              </ul>

              <a class="btn btn-success" href="{{route('user.edit',$data->id)}}"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
              <br />

            </div>
            <div class="col-md-9 col-sm-9 ">

                <div class="row" style="display:block;">
                    <div class="top_tiles">
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                          <div class="count">{{count($data->videos)}}</div>
                          <h3>Total Videos</h3>
                        </div>
                      </div>
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-comments-o"></i></div>
                          <div class="count">{{count($data->playlists)}}</div>
                          <h3>Total Playlist</h3>
                        </div>
                      </div>
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                          <div class="count">{{count($data->videoCats)}}</div>
                          <h3>Total Category</h3>
                        </div>
                      </div>
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-check-square-o"></i></div>
                          <div class="count">179</div>
                          <h3>Total Point</h3>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
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
@push('js')

@endpush
