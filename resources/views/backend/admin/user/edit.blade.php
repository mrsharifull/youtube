@extends('backend.layout.master')
@section('title','Edit Profile')
@push('css_link')
    <link href="{{asset('backend/vendors/google-code-prettify/bin/prettify.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/vendors/starrr/dist/starrr.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Profile</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a href="{{url()->previous()}}" class="btn btn-outline-info btn-sm">Back</a>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{route('user.update',$user->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="name" value="{{$user->name}}" name="name" required="required" class="form-control" placeholder="Enter name">
                        </div>
                        @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="channel_name">Channel Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="channel_name" value="{{$user->channel_name}}" name="channel_name" required="required" class="form-control" placeholder="Enter channel name">
                        </div>
                        @include('alerts.feedback', ['field' => 'channel_name'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Profile Photo<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="file" accept="image/*" id="image" name="image" class="form-control" placeholder="Upload image image">
                            @if($user->image)
                                <div class="image d-flex align-items-center py-4">
                                    <img src="{{asset('storage/'.$user->image)}}" height="150px" width="200px" alt="{{$user->title}}" style="border-radius: 5px; padding:10px; border: 1px solid gray;">
                                </div>
                            @endif
                        </div>
                        @include('alerts.feedback', ['field' => 'image'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="email" id="email" value="{{$user->email}}" name="email" required="required" class="form-control" placeholder="Enter email">
                        </div>
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">New Password</label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password">
                        </div>
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="role">Role <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <select class="form-control" name="role">
                                <option value="admin" {{($user->role == "admin") ? "selected" : ''}}>{{_('Admin')}}</option>
                                <option value="user"  {{($user->role == "user") ? "selected" : ''}}>{{_('User')}}</option>
                            </select>
                        </div>
                        @include('alerts.feedback', ['field' => 'role'])
                    </div>
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js_link')
<script src="{{asset('backend/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js')}}"></script>
<script src="{{asset('backend/vendors/jquery.hotkeys/jquery.hotkeys.js')}}"></script>
<script src="{{asset('backend/vendors/google-code-prettify/src/prettify.js')}}"></script>
<script src="{{asset('backend/vendors/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
<script src="{{asset('backend/vendors/switchery/dist/switchery.min.js')}}"></script>
<script src="{{asset('backend/vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('backend/vendors/parsleyjs/dist/parsley.min.js')}}"></script>
<script src="{{asset('backend/vendors/autosize/dist/autosize.min.js')}}"></script>
<script src="{{asset('backend/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
<script src="{{asset('backend/vendors/starrr/dist/starrr.js')}}"></script>
@endpush
