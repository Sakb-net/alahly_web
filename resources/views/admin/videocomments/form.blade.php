<div class="row">
    <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="box">
            <div class="box-body">
                 <div class="form-group">
                    <label>  الفديو:</label>
                    {!! Form::select('video_id',$videos ,$videoComment, array('class' => 'select2 ','required'=>'')) !!}
                </div>
                @if($new == 0)
                <div class="form-group">
                    <label>الاسم:</label>
                    <label>{{ $comment->name }}</label>
                </div>
                <div class="form-group">
                    <label>البريد الالكترونى:</label>
                    <label>{{ $comment->email }}</label>
                </div>
                @endif
                <div class="form-group">
                    <label>التعليق:</label>
                    {!! Form::textarea('content', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                @if($comment_active > 0)
                    @if($new == 0)
                    <div class="form-group">
                        <label>الحالة:</label>
                        {!! Form::select('is_active',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
                    </div>
                    @endif
                @endif
                
                <div class="box-footer text-center">
                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-info padding-40" >{{trans('app.save')}}</button>
                       <a href="{{$link_return}}" class="btn btn-primary padding-30">{{trans('app.back')}}</a>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

