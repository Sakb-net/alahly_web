<div class="row text-left">
    
    <div class="form-group active-input">
        <label>{{trans('app.password')}}{{trans('app.current')}}</label>
        <input type="password" name="user_pass" placeholder="{{trans('app.password')}}{{trans('app.current')}}" data-rangelength="[6,50]"  data-required="true"  class="input-box form-control" />
    </div>
    <div class="form-group active-input">
        <label>{{trans('app.password')}} {{trans('app.new')}}</label>
        <p class="alert alert-danger raduis user_error_pass hide" style="padding: 0.5rem;"></p>
        <input type="password" name="password"  class="input-box form-control user_pass_buy"  placeholder="{{trans('app.password')}} {{trans('app.new')}}" data-rangelength="[6,50]"  data-required="true" id="password" />
    </div>
    <div class="form-group active-input">
        <label>{{trans('app.confirm')}} {{trans('app.password')}} {{trans('app.new')}}</label>
        <input type="password" name="password_confirmation" class="input-box form-control check_password_confirm"  placeholder="{{trans('app.confirm')}} {{trans('app.password')}} {{trans('app.new')}}" data-rangelength="[6,50]"  data-required="true" data-equalto="#password" />
    </div>
    <div class="clear-fixed" ></div>
    <div class="col-md-12">
        <input name="email_pass" style="color: #fff;" class="butn butn-bg but-input" value="{{trans('app.update')}}" type="submit">
            <!--<button type="submit" name="email_pass" class="butn butn-bg"><span>{{trans('app.update')}}</span></button>-->
    </div>
</div>