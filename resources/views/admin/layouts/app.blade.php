<!DOCTYPE html>
<html>
    <head>
        @include('admin.layouts.head')
        @yield('after_head')
    </head>
    <body class="hold-transition skin-blue sidebar-mini" site-Homeurl="{{ route('home') }}" data-homelang="{{$cuRRlocal}}" data-user="{{ $user_key }}">
        <div class="wrapper">

            @include('admin.layouts.header')
            @include('admin.layouts.sidebar-rtl')
            <div class="content-wrapper">
                <section class="content-header">
                @yield('head_content')
                </section>
                <section class="content">
                @yield('content')
                </section>
            </div>
            @include('admin.layouts.footer')
            <!--@include('admin.layouts.aside')-->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        @include('admin.layouts.foot')          
        @yield('after_foot')
    </body>
</html>