<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="box">
            <div class="box-body">
                <!--dispaly video-->               
                <div class="clearfix"></div>
                <div class=""> 
                    <div class="form-group">
                        <label>عنوان الفديو:</label>
                        {!! Form::text('name', null, array('class' => 'form-control','required'=>'')) !!}
                    </div>
                    {!! Form::hidden('link', '') !!}
                  
                    <div class="form-group">
                        <label>رابط الفديو:</label>
                        {!! Form::text('video', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="clearfix m-b"></div>
                    <div class="form-group">
                        <label>تحميل فديو:</label>
                        <input id="video_content" name="video_content" type="hidden" @if(isset($video->video)) value="{{$video->video}}" @endif>
                        @if($upload==1)
                        <iframe id="myVideo" class="ifram_video"  webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="100px" frameborder="0" @if(isset($video->video)) src="{{$video->video}}" @else  style="display:none;" src="" @endif></iframe>
                        @else
                        <iframe id="myVideo" class="ifram_video"  webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="100px" frameborder="0" src=""></iframe>
                        <object id="myVideo" width="90%" height="230"  type="application/x-shockwave-flash" @if(isset($video->video))  data="{{$video->video}}" @else style="display:none;" @endif>
                                <param name="src" id="myVideo" @if(isset($video->video)) value="{{$video->video}}" @else style="display:none;" @endif />
                        </object>
                        @endif
                        <div class="clearfix m-b"></div>
                        @if($video_active == 1)
                        <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=admin_panel&field_id=video_content')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                        @else
                        <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=user&field_id=video_content')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                        @endif
                        <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                        <input class="video_number" type="hidden" value="1">
                    </div> 

                    <!--                    <div class="form-group">
                                            <label>:ارفاق صورة</label>
                                            <input id="video_image" name="image" type="hidden">
                                            <img  src="" width="80%" height="100px" style="display:none;" />
                                            @if($video_active == 1)
                                            <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=video_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                            @else
                                            <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=video_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                            @endif
                                            <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                                            <input class="image_number" type="hidden" value="1">
                                        </div>-->
                </div>
                <div class="clearfix m-b"></div>
                @if($new == 0 )
                @if($video_active > 0)
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2')) !!}
                </div>
                @endif
                @endif
                <hr/>

                <div class="clearfix"></div>
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="box">
            <div class="box-body">
                  <div class="form-group ">
                        <label>نبذة:</label>
                        {!! Form::textarea('content', null, array('class' => 'form-control','id'=>'my-textarea')) !!}
                    </div>
                <div class="form-group">
                    <label>{{trans('app.image')}} {{trans('app.video')}} : </label>
                    <br>
                    <input id="image" name="image" type="hidden" value="{{ $image_link }}">
                    <img  src="{{ $image_link }}"  width="40%" height="auto" @if($image_link == Null)  style="display:none;" @endif />
                    @if($video_active == 1)
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
