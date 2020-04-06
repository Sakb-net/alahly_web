<div class="row">
    <div class="col-sm-12 col-md-8 col-lg-8">
        <div class="box">
            <div class="box-body">
                <div class="form-group @if($new ==0) hidden @endif">
                    <label>نوع الرسالة:</label>
                    {!! Form::text('type', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>الرسالة باللغة العربية:</label>
                    {!! Form::text('ar_message', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>الرسالة باللغة الانجليزيه:</label>
                    {!! Form::text('en_message', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 hidden">
        <div class="box">
            <div class="box-body ">
                <div class="form-group">
                </div>
            </div>
        </div>
    </div>
</div>

