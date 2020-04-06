<div id="loader-wrapper">
    <div id="loader"></div>
</div>
<header class="header-wrapper">
    <div class="mymenu-wrapper">
        <div class="container">
            <div class="main-content-wrapper clearfix">
                <!-- Logo -->
                <div class="logo float-right">
                    <a href="{{ url('/') }}">
                        @if(!empty($logo_image))
                        <img src="{{ $logo_image}}" alt="Logo">
                        @else
                        <img src="{{ asset('images/logo/logo.png') }}" alt="Logo">
                        @endif
                    </a>
                </div>
                @guest
                <div class=" float-left">
                    <a href="{{ url('register') }}" class="butn butn-bg"><span>حساب جديد</span></a>
                </div>
                @else
                <div class="float-left">
                    <a href="{{ route('profile.index') }}"><span class="white">مرحبا  {{ Auth::user()->display_name }} </span></a>                
                    <a class="btn btn-success" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                        <span>تسجيل خروج</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @endguest
            </div>
            <!-- /.main-content-wrapper -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.header-wrapper -->
</header>