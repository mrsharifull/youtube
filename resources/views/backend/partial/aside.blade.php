            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;">
                    <a href="{{route('admin.dashboard')}}" class="site_title"><i class="fa fa-dashboard"></i> <span>Admin</span></a>
                  </div>

                  <div class="clearfix"></div>

                  <!-- menu profile quick info -->
                  <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="{{Auth::user()->image ? asset('storage/'.Auth::user()->image) : asset('no_img.jpg')}}" alt="{{Auth::user()->name}}"  height="60px" width="60px" class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                      <span>Welcome,</span>
                      <h2>{{ Auth::user()->name }}</h2>
                    </div>
                  </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                {{-- <ul class="nav side-menu">

                    <li><a href="{{route('user.index')}}"><i class="fa fa-users"></i>Users Management</a></li>

                    <li><a><i class="fa fa-video"></i> Video Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                        <li><a href="">Category</a></li>
                        <li><a href="">Video</a></li>
                        </ul>
                    </li> --}}






                <!-- <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">Dashboard</a></li>
                      <li><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                   -->
                {{-- </ul> --}}

                <ul class="nav side-menu">
                    <li><a href="{{route('user.profile',auth()->user()->id)}}"><i class="fa fa-user"></i> Profile</a></li>
                    <li><a href="{{route('user.index')}}"><i class="fa fa-users"></i> User Management</a></li>

                    <li class="{{ Request::is('video/*') ? 'active' : '' }}"><a><i class="fa fa-video-camera"></i> Video Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu {{ Request::is('video/*') ? 'd-block' : '' }}">
                            <li class="{{ Request::is('video/playlist/*') ? 'current-page' : '' }}"><a href="{{route('video.playlist.index')}}"> Playlist</a></li>
                            <li class="{{ Request::is('video/category/*') ? 'current-page' : '' }}"><a href="{{route('video.cat.index')}}">Category</a></li>
                            <li class="{{ Request::is('video/data/*') ? 'current-page' : '' }}"><a href="{{route('video.index')}}">Video</a></li>
                        </ul>
                    </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
          </div>
        </div>
