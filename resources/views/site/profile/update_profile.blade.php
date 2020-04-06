<div class="row text-left">

    <div class="form-group">
        <div class="bi-noti"></div>
        <div class="clearfix"></div>
        <a  class="add_image">
            @if(!empty($user->image))
            <img class="img-thumbnail profile-img member_image_update" src="{{$user->image}}" alt="" />
            @else 
            <span class="img-addcir"><img class="img-thumbnail profile-img member_image_update" src="{{asset('images/user.png') }}"  alt="img"/></span>
            @endif
            <span class="down-img">{{trans('app.upload_profile_image')}}</span>
        </a> 
        <input  class="hide hid-upload change_photo_input"  type="file" name="member_img" value="{{$user->image}}" />
    </div>
    <div class="form-group input-height col-md-6">
        <label>الاسم </label>
        {!! Form::text('name', $user->display_name, array('placeholder' =>trans('app.name'),'class' => 'input-box form-control','data-rangelength'=>'[3,100]')) !!}
    </div>
    <div class="form-group input-height col-md-6">
        <label>البريد الإلكتروني</label>
        {!! Form::email('email', $user->email, array('placeholder' =>trans('app.email'),'class' => 'input-box form-control','required'=>'','data-parsley-type'=>"email")) !!}
    </div>
    <div class="form-group input-height col-md-6">
        <label>رقم الهاتف</label>
        <input type="text" data-type="number" placeholder="{{trans('app.mobile')}}" name="phone"  value="{{ $user->phone }}" class="input-box form-control" />
    </div>
    <div class="form-group col-md-6 hidden">
        <label>اختر دولتك </label>
        {!!country_select($user->address)!!}
    </div>
    <div class="form-group input-height col-md-6">
        <label>{{trans('app.choose_city')}}</label>
        {!!city_select($user->city)!!}
    </div>
    <div class="form-group input-height col-md-6">
        <label>{{trans('app.enter_state')}}</label>
        {!! Form::text('state', $user->state, array('placeholder' =>trans('app.enter_state'),'class' => 'input-box form-control','required'=>'')) !!}
    </div>

    <div class="form-group input-height col-md-6 hidden">
        <label class="label-input">{{trans('app.type_user')}}</label>
        <label class="cir-radio valjsRadio @if($user->gender == 'male' ) active-radio @endif">
            <input value="male" type="radio" name="gender" id="option1" autocomplete="off" @if($user->gender== 'male' ) checked @endif/>
                   <span class="glyphicon glyphicon-ok">{{trans('app.male')}}</span>
        </label>
        <label class="cir-radio valjsRadio @if($user->gender == 'female' ) active-radio @endif">
            <input value="female" type="radio" name="gender" id="option2" autocomplete="off" @if($user->gender== 'female' ) checked @endif/>
                   <span class="glyphicon glyphicon-ok">{{trans('app.female')}}</span>
        </label>
    </div>
    <div class="form-group input-height col-md-6 hidden">
        {!! Form::text('birth_day', $birth_day, array('placeholder' =>trans('app.birthday'),'class' => 'input-box form-control','id'=>'datepicker','data-date-format'=>'yyyy-mm-dd')) !!}
    </div>
    <div class="clear-fixed" ></div>
    <div class="col-md-12">
        <input name="submit" style="color: #fff;margin-top: 10px;" class="butn butn-bg but-input" value="{{trans('app.update')}}" type="submit">
     <!--<button type="submit" name="submit" class="butn butn-bg"><span>{{trans('app.update')}}</span></button>-->
    </div>

</div>