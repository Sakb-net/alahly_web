<div class="header-wrapper">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 left-list">
                    <span class="address">
                        <i class="fa fa-globe"></i>
                        <a href="#">English</a>
                    </span>
                    <span class="address">
                        @guest
                        <i class="fa fa-sign-in"></i>
                        <a href="{{ url('login') }}">تسجيل الدخول</a> / <a href="{{ url('register') }}">حساب جديد</a>
                        @else
                        <i class="fa fa-sign-out"></i>
                        <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">تسجيل خروج</a> /
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        <a href="{{ route('profile.index') }}">{{ Auth::user()->display_name }}</a>
                        @endguest
                    </span>
                </div>
                <!-- /.left-list -->
                <div class="col-md-6 col-sm-6 col-xs-12 right-list text-right hidden-xs">
                    @include('site.layouts.social_icon')
                </div>
                <!-- /.right-list -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
</div>