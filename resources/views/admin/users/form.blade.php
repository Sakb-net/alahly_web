<div class="row">
    <div class="col-sm-8 col-xs-8 col-lg-8">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>اسم رابط المستخدم:</label>

                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required'=>'')) !!}
                </div>

                <div class="form-group">

                    <label>الاسم :</label>

                    {!! Form::text('display_name', null, array('placeholder' => 'Display Name','class' => 'form-control')) !!}
                </div>

                <div class="form-group">

                    <label>البريد الالكترونى:</label>

                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','required'=>'','data-parsley-type'=>"email")) !!}

                </div>

                <div class="form-group">

                    <label>الهاتف:</label>

                    {!! Form::text('phone', null, array('placeholder' => 'Phone','class' => 'form-control')) !!}

                </div>

                <div class="form-group">

                    <label>العنوان:</label>

                    {!! Form::text('address', null, array('placeholder' => 'address','class' => 'form-control')) !!}

                </div>
                @if($new==1)
                    <div class="form-group">
                       <label>كلمة المرور:</label>
                       {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password','data-parsley-minlength'=>'8')) !!}
                   </div>
                   <div class="form-group">
                       <label>تاكيد كلمة المرور:</label>
                       {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control','data-parsley-equalto'=>'#password')) !!}
                   </div>
                @else
                    @if(isset($user))
                    <!--&& $user->id == Auth::user()->id-->
                    <div class="form-group">
                        <label>كلمة المرور:</label>
                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password','data-parsley-minlength'=>'8')) !!}
                    </div>
                    <div class="form-group">
                        <label>تاكيد كلمة المرور:</label>
                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control','data-parsley-equalto'=>'#password')) !!}
                    </div>
                    @endif
                @endif
                @if(Auth::user()->can('access-all', 'user-all'))
                <div class="form-group">
                    <label>الوظائف:</label>
                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'select2','multiple')) !!}
                </div>
                <div class="form-group">
                    <label>نوع المستخدم:</label>
                    {!! Form::select('gender',genderType() ,null, array('class' => 'select2')) !!}
                </div>
              
                @endif
                
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2')) !!}
                </div>
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4 col-xs-4 col-lg-4">
        <div class="box">
            <div class="box-body">
                <div class="form-group">

                    <label>الصورة:</label>

                    <input id="image" name="image" type="hidden" value="{{ $image }}">
                    <img  src="{{ $image }}"  width="60%" height="auto" @if($image == Null)  style="display:none;" @endif />
                          @if(Auth::user()->can('access-all', 'user-all'))
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>

                </div>
            </div>
        </div>
    </div>

</div>
