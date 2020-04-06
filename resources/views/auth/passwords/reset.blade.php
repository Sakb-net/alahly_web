@extends('site.layouts.app',['title' => 'Reset Password'])
@section('content')
<section class="hero-area" id="slideslow-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="hero-area-content">
                    <h1>إعادة كلمة المرور </h1>   
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form data-validate="parsley" role="form" class="panel-login" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <!--<label for="email" class="control-label">البريد الإلكترونى </label>-->
                            <input id="email" type="email" class="input-box form-control" name="email" value="{{ old('email') }}" placeholder="{{trans('app.enter_your_email')}}"  required autofocus />
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group  {{ $errors->has('password') ? ' has-error' : '' }}">
                            <!--<label> كلمة المرور </label>-->
                            <input id="password" type="password" data-rangelength="[8,50]" name="password" required class="input-box form-control" required placeholder="{{trans('app.password')}}" />
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <!--<label for="password-confirm" >تأكيد كلمة المرور </label>-->
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="{{trans('app.confirm')}} {{trans('app.password')}}">
                            @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <input type="submit" name="login-submit" id="login-submit" class="butn butn-bg" value="ارسال">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
