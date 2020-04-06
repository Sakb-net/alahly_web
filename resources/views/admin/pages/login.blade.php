<!DOCTYPE html>
<html>
    <head>
        @include('admin.layouts.head')
        @section('title') تسجيل دخول 
        @stop

    </head>
    <body class="hold-transition login-page">

        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('home') }}">الصفحة الرئيسية</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.login') }}">
                    {{ csrf_field() }}

                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="form-control" name="email" placeholder="email" value="{{ old('email') }}" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif

                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" placeholder="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                      
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                       
                       


            </div>
            <!-- /.login-box-body -->
        </div>  
        @include('admin.layouts.foot')


    </body>
</html>



