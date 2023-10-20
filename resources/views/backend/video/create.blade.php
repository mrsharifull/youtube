@extends('backend.layout.master')
@section('title','Create Video')
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
                <h2>Add Video</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a href="{{route('video.index')}}" class="btn btn-outline-info btn-sm">Back</a>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{route('video.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="playlist_id">Playlist<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="playlist_id" class="form-control" id="playlist_id" required="required">
                                <option selected hidden>Select Playlist</option>
                                @foreach ($playlists as $playlist)
                                    <option value="{{$playlist->id}}">{{$playlist->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @include('alerts.feedback', ['field' => 'playlist_id'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cat_id">Video Category<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="cat_id" class="form-control" id="cat_id" required="required">
                                <option selected hidden>Select Video Category</option>
                                @foreach ($cats as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @include('alerts.feedback', ['field' => 'cat_id'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Video Title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="title" name="title" required="required" class="form-control" placeholder="Enter video title">
                        </div>
                        @include('alerts.feedback', ['field' => 'title'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="video">Upload Video<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="file" accept="video/*" id="video" name="video" required="required" class="form-control" placeholder="Upload Video">
                        </div>
                        @include('alerts.feedback', ['field' => 'video'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="thumbnail">Thumbnail<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="file" accept="image/*" id="thumbnail" name="thumbnail" required="required" class="form-control" placeholder="Upload thumbnail image">
                        </div>
                        @include('alerts.feedback', ['field' => 'thumbnail'])
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="description">Description<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <textarea name="description" class="form-control" id="description"  rows="10" placeholder="Enter Video Description"></textarea>
                        </div>
                        @include('alerts.feedback', ['field' => 'description'])
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
