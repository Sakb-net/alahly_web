<!DOCTYPE html>
<html>
    <head>
        @include('site.layouts.head')
        @yield('after_head')
        {!! $facebook_pixel !!}
    </head>
    <body  class="" site-Homeurl="{{ route('home') }}" data-homelang="{{$cuRRlocal}}" data-user="{{ $user_key }}">
        {!! $google_analytic !!} 
        <div class="main-page-wrapper">
            <div id="loader-wrapper">
                <div id="loader"></div>
            </div>
        @include('site.layouts.header')
        @yield('content')
        @include('site.layouts.footer')        
        @include('site.layouts.foot')
        @yield('after_foot')
        </div>
    </body>
</html>
