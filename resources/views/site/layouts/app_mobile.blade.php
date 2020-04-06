<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Meta -->
        <meta name="author" content="ALAHLIFC">
        <meta name="designer" content="ALAHLIFC">
        <meta name="owner" content="{{ config('app.name', 'ALAHLIFC') }}">
        <meta name="revisit-after" content="7 days">

        <!-- CSRF Token -->
        <meta name="_token" content="{{ csrf_token() }}"/>

        <!-- Title -->
        <title>{{ $title }} </title>
        <!-- CSS -->
        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('images/fav-icon/icon.png') }}">
        <!-- Main style sheet -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/site/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/site/css/custom.css') }}">
        @yield('after_head')
    </head>
    <body  class="">
        <div class="main-page-wrapper">
            @yield('content')
            <!-- JS  -->
            <script src="{{ asset('js/site/lib/plugins/jquery.2.2.3.min.js') }}"></script>
            <!-- Bootstrap JS -->
            <script src="{{ asset('js/site/lib/plugins/bootstrap/bootstrap.min.js') }}"></script>
            <!-- veagas js -->
            <script src="{{ asset('js/site/lib/plugins/vegas/vegas.min.js') }}"></script>
            <!-- Theme js -->
            <script src="{{ asset('js/site/lib/js/theme.js') }}"></script>
            @yield('after_foot')
        </div>
    </body>
</html>
