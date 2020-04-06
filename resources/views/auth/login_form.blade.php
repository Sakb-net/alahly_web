<section class="hero-area" id="slideslow-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="hero-area-content">
                    <h1>مرحبا بك قم بتسجيل الدخول</h1>   
                    <div class="text-center mb-10">
                        @include('site.layouts.alert_save')
                    </div>
                    <form data-validate="parsley" role="form" class="panel-login" method="POST" action="{{ route('login') }}">
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
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                               <label for="remember" id="remember-text">تذكرني</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                    <div class="col-md-6">
                                        <a href="{{ route('password.request') }}" id="forgot-password">هل نسيت كلمة المرور؟</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <input type="submit" name="login-submit" id="login-submit" class="butn butn-bg" value="تسجيل الدخول">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('register') }}">ليس لديك حساب؟</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>