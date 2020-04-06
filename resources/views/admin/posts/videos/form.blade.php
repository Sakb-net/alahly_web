<div class="row">
    <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="box">
            <div class="box-body">
            <div class="clearfix m-b"></div>
                <div class="raw video-repeater">
                    <div  data-repeater-list="video" >
                        @if(count($all_video)!=0)
                         @foreach ($all_video as $key => $video)
                        <div  data-repeater-item>
                            <div class="col-sm-11">    
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <label>عنوان الفديو</label>
                                    </div>
                                    <div class="col-sm-8">
                                {!! Form::text('name', $video->name, array('class' => 'form-control','required'=>'')) !!}
                                    </div>
                                </div>
                                 {!! Form::hidden('link', $video->link) !!}

                                <div class="col-sm-6">
                                    <div class="col-sm-5">
                                        <label>حاله العرض</label>
                                    </div>
                                    <div class="col-sm-7">
                                        
                                @if($post_active > 0)
                                <!--<div class="form-group">-->
                                    <!--<label>الحالة:</label>-->
                                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
                                <!--</div>-->
                                @endif
                                    </div>
                                </div>

                                <div class="clearfix m-b"></div>

                                <div class="col-sm-6">
                                    <div class="col-sm-3">
                                        <label>ارفاق فديو</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input id="video_content{{$key}}" name="video_content" type="hidden" value="{{$video->video}}">
                                        <iframe id="myVideo" class="ifram_video"  src="{{$video->video}}" webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="100px" frameborder="0"></iframe>
                                        <div class="clearfix m-b"></div>
                                        @if($post_active == 1)
                                        <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=video_content')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                        @else
                                        <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=video_content')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                        @endif
                                        <a href="#" class="btn btn-danger btn-s-xs fa fa-remove remove_video_image" type="button"></a>
                                        <input class="video_content" type="hidden" value="{{$key}}">
                                    </div> 
                                </div> 

                                <div class="col-sm-6 ">
                                    <div class="col-sm-3">
                                        <label>ارفاق صورة</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input id="video_image{{$key}}" name="video_image" type="hidden" value="{{$video->image}}">
                                        <img  src="{{$video->image}}"  width="70%" height="100px" @if($video->image == '') style="display:none;" @endif />
                                        @if($post_active == 1)
                                        <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=video_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                        @else
                                        <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=video_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                        @endif
                                        <a href="#" class="btn btn-danger btn-s-xs fa fa-remove remove_video_image" type="button"></a>
                                        <input class="video_number" type="hidden" value="{{$key}}">
                                    </div>     
                                </div>
                                <input type="hidden" name="video_id" value="[@value.video_id]" class="form-control m-b" >
                                <div class="clearfix m-b"></div> <hr/>
                            </div>

                            <div class="col-sm-1 bi-input">
                                <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                            </div> 
                        </div> 
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="box">
            <div class="box-body">
<!--dispaly video-->               
                <div class="clearfix"></div>
                <div class="col-md-3 col-sm-4">
                    <input  type="button" class="btn btn-success btn-s-xs video-add-show" value="اضافة  فديو"/>
                </div>
                <div class="clearfix"></div>
                <div class="raw video-add-repeater hide">
                    <div  data-repeater-list="video_add" >
                        <div  data-repeater-item>

                            <div class="col-sm-11"> 
                                <div class="col-sm-7">
                                    <div class="col-sm-4">
                                        <label>عنوان الفديو</label>
                                    </div>
                                    <div class="col-sm-8">
                                        {!! Form::text('name', null, array('class' => 'form-control','required'=>'')) !!}
                                    </div>
                                </div>
                                {!! Form::hidden('link', '') !!}
                                <div class="clearfix m-b"></div>

                                <div class="col-sm-6">
                                    <div class="col-sm-3">
                                        <label>ارفاق فديو</label>
                                    </div>
                                    <div class="col-xs-9">
                                        <input id="video_content" name="video_content" type="hidden" >
                                        <iframe id="myVideo"  src="" webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="100px" frameborder="0" style="display:none;"></iframe>
                                        <div class="clearfix m-b"></div>
                                       @if($post_active == 1)
                                        <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=video_content')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                        @else
                                        <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=video_content')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                        @endif
                                          <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                                        <input class="video_number" type="hidden" value="1">
                                    </div>
                                </div> 

                                <div class="col-sm-6 ">
                                    <div class="col-sm-3">
                                        <label>ارفاق صورة</label>
                                    </div>

                                    <div class="col-xs-9">
                                        <input id="video_image" name="video_image" type="hidden">
                                        <img  src="" width="80%" height="100px" style="display:none;" />
                                        @if($post_active == 1)
                                        <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=video_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                        @else
                                        <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=video_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                                        @endif
                                        <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                                        <input class="image_number" type="hidden" value="1">
                                    </div> 
                                </div>
                            </div>
                            <div class="col-sm-1 bi-input">
                                <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                            </div> 
                            <div class="clearfix m-b"></div> <hr/>
                        </div>
                    </div>

                    <div class="col-sm-4  m-b">
                        <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  فديو"/>
                    </div>
                </div>
                <div class="clearfix"></div>
                  <div class="box-footer text-center">
                     <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
    
</div>
