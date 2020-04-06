<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="box">
            <div class="box-body">
                {!! Form::hidden('type', 'blog') !!}
                {!! Form::hidden('lang',$lang) !!}
                {!! Form::hidden('lang_id',$lang_id) !!}
                <div class="form-group">
                    <label>{{trans('app.name')}}  {{trans('app.new_one')}} : {{$lang}}</label>
                    {!! Form::text('name', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group hidden">
                    <label> {{trans('app.slug')}} : {{$lang}}</label>
                    @if($new > 0 )
                    {!! Form::text('link', null, array('class' => 'form-control')) !!}
                    @else
                    {!! Form::text('link', null, array('class' => 'form-control','required'=>'')) !!}
                    @endif
                </div>
                <div class="form-group">
                    <label>{{trans('app.abstract')}} : {{$lang}}</label>
                    <!--,'id'=>'my-textarea'-->
                    {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                </div>
               <div class="form-group">
                    <label>Tags {{trans('app.search')}} : {{$lang}}</label>
                    {!! Form::select('tags[]', $tags,$blogTags, array('class' => 'select2-tags','multiple')) !!}
                </div>
                @if($blog_active > 0)
                    @if($new == 0)
                    <div class="form-group">
                        <label>{{trans('app.state')}} : {{$lang}}</label>
                        @if($lang=='en')
                            {!! Form::select('is_active',statusTypeEn() ,null, array('class' => 'select2','required'=>'')) !!}
                        @else
                            {!! Form::select('is_active',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
                        @endif 
                    </div>
                    @endif
                @endif
                <div class="box-footer text-center">
                     <button type="submit" class="btn btn-info padding-40" >{{trans('app.save')}}</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">{{trans('app.back')}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="box">
            <div class="box-body">
                @if($image == 1)
                <div class="form-group">
                    <label>{{trans('app.image')}} {{trans('app.new_one')}} : {{$lang}}</label>
                    <br>
                    <input id="image" name="image" type="hidden" value="{{ $image_link }}">
                    <img  src="{{ $image_link }}"  width="40%" height="auto" @if($image_link == Null)  style="display:none;" @endif />
                    @if($blog_active == 1)
                    <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
                @endif
                
                <div class="form-group hidden">
                    <label> {{trans('app.color')}} : {{$lang}}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        @if(isset($color))
                        {!! Form::text('color', $color, array('class' => 'form-control my-colorpicker1 colorpicker-element','required'=>'')) !!}
                        <div class="input-group-addon">
                            <i style="background-color:{{$color}}"></i>
                        @else
                            @if($new==1)
                             {!! Form::text('color','#000', array('class' => 'form-control my-colorpicker1 colorpicker-element','required'=>'')) !!}
                            <div class="input-group-addon">
                                <i style="background-color: #000;"></i>
                            @else
                             {!! Form::text('color', null, array('class' => 'form-control my-colorpicker1 colorpicker-element','required'=>'')) !!}
                            <div class="input-group-addon">
                                <i style="background-color: "></i>
                            @endif
                        @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{trans('app.detail_desc')}} : {{$lang}}</label>
                    {!! Form::textarea('description', null, array('class' => 'form-control','id'=>'my-textarea')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
