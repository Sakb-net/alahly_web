<div class="row">
    <div class="col-sm-9 col-xs-9 col-lg-9">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>الاسم:</label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>الاسم الظاهر:</label>
                    {!! Form::text('display_name', null, array('placeholder' => 'Display Name','class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>الوصف:</label>
                    {!! Form::text('description', null, array('placeholder' => 'description','class' => 'form-control')) !!}
                </div>                
                <div class="box-footer text-center">
                      <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
</div>

