<div class="row">
    <div class="col-sm-12 col-md-8 col-lg-8">
        <div class="box">
            <div class="box-body">
                <!--{!! Form::hidden('type', 'fees') !!}-->
                <div class="form-group">
                    <label>الاسم الرسوم:</label>
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
                <div class="form-group hidden">
                    <label>نبذة/ ملاحظة:</label>
                    {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label>التكلف :</label>
                            {!! Form::number('price', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label>نوع التكلفة:</label>
                            {!! Form::select('type_price',FeesTypePrice() ,null, array('class' => 'select2')) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>كلمات دلالية:</label>
                    {!! Form::select('tags[]', $tags,$feesTags, array('class' => 'select2-tags','multiple')) !!}
                </div>
                @if($fees_active > 0&&$new ==0)
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
    <div class="col-sm-12 hidden">
        <div class="box">
            <div class="box-body ">
                <div class="form-group">
                </div>
            </div>
        </div>
    </div>
</div>

