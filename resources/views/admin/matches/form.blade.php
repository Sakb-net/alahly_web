<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6 ">
        <div class="box">
            <div class="box-body">
                {!! Form::hidden('type',$type) !!}
                {!! Form::hidden('lang',$lang) !!}
                <div class="form-group">
                    <label>{{trans('app.name')}} {{trans('app.match')}}:</label>
                    {!! Form::text('name', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group hidden">
                    <label>الرابط:</label>
                    @if($new > 0 )
                    {!! Form::text('link', null, array('class' => 'form-control')) !!}
                    @else
                    {!! Form::text('link', null, array('class' => 'form-control','required'=>'')) !!}
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>{{trans('app.start_end_booking_match')}}:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <!--'id'=>'reservation' 'id'=>'reservationtime'-->
                            {!! Form::text('date_booking', $date_booking, array('class' => 'form-control pull-right','id'=>'reservation')) !!}
                        </div>
                    </div>
                </div>
                <div class="clear-fixed m-b"></div>
                <div class="form-group">
                    <div class="col-sm-12 col-md-7 col-lg-7">
                        <label>{{trans('app.date')}} {{trans('app.match')}}:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <!--'id'=>'reservation' 'id'=>'reservationtime'-->
                            {!! Form::text('date', $date, array('class' => 'form-control pull-right','id'=>'datepicker')) !!}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-5">
                        <div class="bootstrap-timepicker">
                            <label>{{trans('app.time')}} {{trans('app.match')}}:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                {!! Form::text('time', $time, array('class' => 'form-control timepicker pull-right','id'=>'')) !!}
                            </div>                     
                        </div>
                    </div>
                </div>
                <div class="clear-fixed m-b"></div>
                <div class="form-group">
                    <label>{{trans('app.video')}} : {{$lang}}</label>
                    {!! Form::select('video_id',$videos ,null, array('class' => 'select2')) !!}
                </div>
                <div class="form-group hidden">
                    <label>{{trans('app.file')}} : {{$lang}}</label>
                    {!! Form::select('file_id',$files ,null, array('class' => 'select2')) !!}
                </div>
                <div class="clear-fixed m-b"></div>
                <div class="form-group">
                    <label>نبذة مختصرة:</label>
                    {!! Form::textarea('content', null, array('class' => 'form-control','rows' => '2')) !!}
                </div>
                <div class="form-group">
                    <label>الوصف التفصيلى :</label>
                    {!! Form::textarea('description', null, array('class' => 'form-control','id'=>'my-textarea')) !!}
                </div>
                <div class="form-group">
                    <label>الكلمات البحث:</label>
                    {!! Form::select('tags[]', $tags,$dataTags, array('class' => 'select2-tags','multiple')) !!}
                </div>
                @if($new == 0 )
                @if($match_active > 0)
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
                </div>
                @endif
                @endif
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 ">
        <div class="box">
            <div class="box-body">
                @if($image == 1)
                <div class="form-group">
                    <label>صورة الفريق الاول :</label>
                    <br>
                    <input id="first_image" name="first_image" type="hidden" value="{{ $first_image }}">
                    <img  src="{{ $first_image }}"  width="40%" height="100px" @if($first_image == Null)  style="display:none;" @endif />
                          @if($match_active == 1)
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=first_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=first_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
                <div class="form-group">
                    <label>صورة الفريق الثانى :</label>
                    <br>
                    <input id="second_image" name="second_image" type="hidden" value="{{ $second_image }}">
                    <img  src="{{ $second_image }}"  width="40%" height="100px" @if($second_image == Null)  style="display:none;" @endif />
                          @if($match_active == 1)
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=second_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=second_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
                @endif
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label>اسم الفريق الاول:</label>
                            {!! Form::text('first_team', null, array('class' => 'form-control','required'=>'')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label>اسم الفريق الثانى:</label>
                            {!! Form::text('second_team', null, array('class' => 'form-control','required'=>'')) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label>أهداف الفريق الاول:</label>
                            {!! Form::number('first_goal', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label>أهداف الفريق الثانى:</label>
                            {!! Form::number('second_goal', null, array('class' => 'form-control')) !!}                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label>الضربات الركنية	 الفريق الاول:</label>
                            {!! Form::number('strikes1', $strikes1, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label>الضربات الركنية	 الفريق الثانى:</label>
                            {!! Form::number('strikes2', $strikes2, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> التسلل	 الفريق الاول:</label>
                            {!! Form::number('offside1', $offside1, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> التسلل	 الفريق الثانى:</label>
                            {!! Form::number('offside2', $offside2, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> الكروت الصفراء		 الفريق الاول:</label>
                            {!! Form::number('cart_yellow1', $cart_yellow1, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> الكروت الصفراء		 الفريق الثانى:</label>
                            {!! Form::number('cart_yellow2', $cart_yellow2, array('class' => 'form-control')) !!}                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> الكروت الحمراء		 الفريق الاول:</label>
                            {!! Form::number('cart_red1', $cart_red1, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> الكروت الحمراء		 الفريق الثانى:</label>
                            {!! Form::number('cart_red2', $cart_red2, array('class' => 'form-control')) !!}    
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> التسديد على المرمى		 الفريق الاول:</label>
                            {!! Form::number('paying_goal1', $paying_goal1, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> التسديد على المرمى		 الفريق الثانى:</label>
                            {!! Form::number('paying_goal2', $paying_goal2, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> التمريرات	 الفريق الاول:</label>
                            {!! Form::number('passes1', $passes1, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 ">
                            <label> التمريرات	 الفريق الثانى:</label>
                            {!! Form::number('passes2', $passes2, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <hr>
                @include('admin.matches.repeaterteam_1') 
                <hr>
                @include('admin.matches.repeaterteam_2') 
            </div>
        </div>
    </div>
