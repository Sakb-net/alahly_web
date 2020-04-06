<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-10">
        <div class="box">
            <div class="box-body">
                {!! Form::hidden('type', 'calendar') !!}
                {!! Form::hidden('lang', $lang) !!}
                <div class="form-group">
                    <label>المناسبة:</label>
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
                    <label>	تاريخ المناسبة:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <!--'id'=>'reservation' 'id'=>'reservationtime'-->
                        {!! Form::text('date', null, array('class' => 'form-control pull-right','id'=>'datepicker','required'=>'')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>نبذة/ ملاحظة:</label>
                    {!! Form::textarea('content', null, array('row'=>'2','class' => 'form-control')) !!}
                </div>
                <div class="form-group hidden">
                    <label>كلمات دلالية:</label>
                    {!! Form::select('tags[]', $tags,$calendarTags, array('class' => 'select2-tags','multiple')) !!}
                </div>
                @if($calendar_active > 0&&$new ==0)
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2')) !!}
                </div>
                @endif

                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 hidden">
        <div class="box">
            <div class="box-body ">
                <div class="form-group ">
                    <label>الصورة:</label>
                    <input id="icon_image" name="icon_image" type="hidden" value="{{ $icon_image }}">
                    <img  src="{{ $icon_image }}"  width="60%" height="auto" @if($icon_image == Null)  style="display:none;" @endif />
                          @if(Auth::user()->can('access-all', 'user-all'))
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=icon_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=icon_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
            </div>
        </div>
    </div>
</div>