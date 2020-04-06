<div class="row">
    <div class="col-sm-8">
        <div class="box">
            <div class="box-body">
                {!! Form::hidden('type', 'posts') !!}
                @if($post_active == 1)
                <div class="form-group">
                    <label>اسم الكاتب:</label>
                    {!! Form::select('user_id',$users ,null, array('class' => 'select2')) !!}
                </div>
                @endif
                <div class="form-group">
                    <label>الاسم:</label>
                    {!! Form::text('name', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>الرابط:</label>
                    @if($new > 0 )
                    {!! Form::text('link', null, array('class' => 'form-control')) !!}
                    @else
                    {!! Form::text('link', null, array('class' => 'form-control','required'=>'')) !!}
                    @endif
                </div>
                <div class="form-group">
                    <label>المحتوى:</label>
                    {!! Form::textarea('content', null, array('class' => 'form-control','id'=>'my-textarea')) !!}
                </div>
                <div class="form-group">
                    <label>الوسوم:</label>
                    {!! Form::select('tags[]', $tags,$postTags, array('class' => 'select2-tags','multiple')) !!}
                </div>
                <div class="form-group">
                    <label>الاقسام:</label>
                    {!! Form::select('categories[]', $categories,$postCategories, array('class' => 'select2','multiple','required'=>'')) !!}
                </div>
                @if($post_active > 0)
                <div class="form-group">
                    <label>التعليقات:</label>
                    {!! Form::select('is_comment',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
                </div>
                @endif
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box">
            <div class="box-body">
                @if($image == 1)
                <div class="form-group">

                    <label>الصورة:</label>
                    <br>
                    <input id="image" name="image" type="hidden" value="{{ $image_link }}">
                    <img  src="{{ $image_link }}"  width="75%" height="auto" @if($image_link == Null)  style="display:none;" @endif />
                    @if($post_active == 1)
                    <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>

                </div>
                @endif
                <div class="form-group">
                    <label>الملخص:</label>
                    {!! Form::textarea('excerpt', null, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label>الوصف :</label>
                    {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                </div>

            </div>
        </div>
    </div>
</div>
