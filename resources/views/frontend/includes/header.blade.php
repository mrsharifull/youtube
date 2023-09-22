<section class="header">
        <div class="container">
            <div class="main-container">
                <div class="main-container-1">

                    <div class="main-container-content-1">
                        <i class="fa-solid fa-bars" class="service-icon"></i>
                        <img src="{{asset('frontend/images/pngwing.com.png')}}" alt="">
                    </div>

                </div>
                <div class="main-container-2">

                    <div class="main-container-content-2">

                        <div class="main-container-content-2">
                            <input type="search" class="search">
                            <input type="submit" value="" class="submit">
                            <i class="fa-solid fa-microphone"></i>
                        </div>


                    </div>
                </div>
                <div class="main-container-3">

                    <div class="main-container-content-3">
                        <i class="fa-solid fa-video"></i>

                        <i class="fa-regular fa-bell"></i>

                        <span class="span">9+</span>
                        @if(auth()->user() == false)
                            <a class="login" href="{{ route('login') }}">{{ __('Login') }}</a>
                            <a class="registration" href="{{ route('register') }}">{{ __('Register') }}</a>

                        @else
                            @if(auth()->user()->role == 'admin')
                            <a class="nav-link dashboard" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                            @else
                            <a class="nav-link dashboard" href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a>
                            @endif
                        @endif

            </div>
        </div>
    </section>
