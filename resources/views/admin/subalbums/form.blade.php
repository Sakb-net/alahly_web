<div class="row">
    <div class="col-sm-8 col-md-8 col-lg-8">
        <div class="box">
            <div class="box-body">

                {!! Form::hidden('type', 'sub') !!}
                <div class="form-group">
                    <label>الاسم:</label>
                    {!! Form::text('name', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>القسم الالبوم:</label>
                    {!! Form::select('parent_id',$albums ,$parent_id, array('class' => 'select2')) !!}
                </div>
                <div class="form-group">
                    <label>الرابط:</label>
                    @if($new > 0 )
                    {!! Form::text('link', null, array('class' => 'form-control')) !!}
                    @else
                    {!! Form::text('link', null, array('class' => 'form-control','required'=>'')) !!}
                    @endif
                </div>
                <div class="form-group hidden">
                    <label>نبذة:</label>
                    {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                </div>
                @if($new == 0 )
                @if($category_active > 0)
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2')) !!}
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
    <div class="col-sm-4">
        <div class="box">
            <div class="box-body">
                <div class="form-group">

                    <label>الصورة:</label>

                    <input id="icon_image" name="image" type="hidden" value="{{ $icon_image }}">
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
