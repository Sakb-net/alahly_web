@extends('site.layouts.app',['title' => 'Register-ALAHLIFC'])
@section('content')
<section class="hero-area" id="slideslow-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="hero-area-content">
                    <h1>مرحبا بك قم بالاشتراك معانا</h1>
                    <div class="text-center mb-10">
                        @include('site.layouts.alert_save')
                    </div>
                    <form data-validate="parsley" class="panel-login" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group  {{ $errors->has('name') ? ' has-error' : '' }}">
                            <!--<label> أسم المستخدم </label>-->
                            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required placeholder="{{trans('app.name')}}" autofocus/>
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }}">
                            <p class="alert alert-danger raduis user_error_emailss hide" style="padding: 0.5rem;"></p>
                            <!--<label> البريد الإلكترونى  </label>-->
                            <input data-required="true"  data-type="email"  data-rangelength="[3,250]" name="user_email" value="" id="user_email_buy" type="email" class="user_email_buy hide form-control" />
                            <input type="email"  data-rangelength="[3,250]" name="email" value="{{ old('email') }}" id="email" class="db_user_email_buy form-control" required placeholder="{{trans('app.enter_your_email')}}" />
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group  {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <p class="alert alert-danger raduis user_error_phone hide" style="padding: 0.5rem;"></p>
                            <!--<label> الهاتف </label>-->
                            <input data-type="number" name="phone" type="text" id="user_phone_buy" value="" class="form-control user_phone_buy hide" />
                            <input id="phone" type="phone" name="phone" value="{{ old('email') }}" class="form-control db_user_phone_buy" required placeholder="{{trans('app.mobile')}}" />
                            @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('city') ? ' has-error' : '' }}">
                                    <p class="alert alert-danger raduis user_error_city hide" style="padding:1px;font-size: 13px;"></p>
                                    {!!city_select()!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('state') ? ' has-error' : '' }}">
                                    <p class="alert alert-danger raduis user_error_state hide" style="padding:1px;font-size: 13px;"></p>
                                    <input id="state" type="state" name="state" class="form-control user_pass_state"  required placeholder="{{trans('app.enter_state')}}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <p class="alert alert-danger raduis user_error_pass hide" style="padding:1px;font-size: 13px;"></p>
                                    <!--<label> كلمة المرور </label>-->
                                    <input id="password" type="password" name="password" class="form-control user_pass_buy" data-equalto="#password" required placeholder="{{trans('app.password')}}" />
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <!--<label> تأكيد كلمة المرور </label>-->
                                    <input id="password-confirm" type="password" name="password_confirmation" class="form-control check_password_confirm" data-equalto="#password" required placeholder="{{trans('app.confirm')}} {{trans('app.password')}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <input type="submit" name="register-submit" id="register-submit" class="butn butn-bg" value="إنشاء حساب">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('login') }}" class="Link">  هل لديك حساب  ؟ </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
