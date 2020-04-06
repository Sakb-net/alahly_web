        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- CSRF Token -->
        <meta name="_token" content="{{ csrf_token() }}"/>
        <title> @yield('title') &#8211; ALAHLIFC</title>
        <!--<title> @yield('title') &#8211; {{ config('app.name', 'ALAHLIFC')}}</title>-->
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.min.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/admin/ar/bootstrap-rtl.min.css') }}" >
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('css/admin/font-awesome.min.css') }}" >
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('css/admin/ionicons.min.css') }}" >
        <!-- daterange picker -->
        <link rel="stylesheet" href="{{ asset('css/admin/daterangepicker.css') }}" >
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="{{ asset('css/admin/bootstrap-datepicker.css') }}" >
        <!-- Bootstrap Color Picker -->
        <!--<link rel="stylesheet" href="{{ asset('css/admin/bootstrap-colorpicker.min.css') }}" >-->
        <link rel="stylesheet" href="{{ asset('css/admin/ar/bootstrap-colorpicker.min_ar.css') }}" >
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="{{ asset('css/admin/bootstrap-timepicker.min.css') }}" >
        <!--  datatable -->
        <link rel="stylesheet" href="{{ asset('css/admin/dataTables.bootstrap.min.css') }}" >
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="{{ asset('css/admin/all-flat.css') }}" >
        <!-- fancybox -->
        <link rel="stylesheet" href="{{ asset('css/admin/jquery.fancybox.css') }}" >
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('css/admin/select2.min.css') }}" >
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('css/admin/app.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/ar/app-rtl.min.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('css/admin/all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/ar/all-skins-rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/project.css') }}">
        <!--<link rel="icon" href="{{ asset('images/favicon.ico') }}">-->
<link rel="icon" type="image/png" sizes="56x56" href="{{ asset('images/fav-icon/icon.png') }}">
        <!-- Scripts -->
<!--        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
            ]) !!};
        </script>-->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

