<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="box">
            <div class="box-body">
                {!! Form::hidden('type',$type) !!}
                {!! Form::hidden('typePost', $type) !!}
                <div class="form-group">
                    <label>العنوان:</label>
                    @if($type =='banner')
                    {!! Form::text('name', null, array('class' => 'form-control')) !!}
                    @else
                    {!! Form::text('name', null, array('class' => 'form-control','required'=>'')) !!}
                    @endif
                </div>
                <div class="form-group">
                    <label>الرابط:</label>
                    @if($new > 0 )
                    {!! Form::text('link', null, array('class' => 'form-control')) !!}
                    @else
                    {!! Form::text('link', null, array('class' => 'form-control','required'=>'')) !!}
                    @endif
                </div>
                @if($type!='banner')
                <div class="form-group hidden">
                    <label>القسم الرئيسى :</label>
                    <!--ajax_get_subcategory-->
                    {!! Form::select('category_id',$categories ,$postCategories, array('class' => 'select2  type_cat','id'=>'type_cat','required'=>'')) !!}
                </div>
                @else
                {!! Form::hidden('category_id', '11') !!}
                @endif
                <div class="form-group">
                    <label>الوصف التفصيلى :</label>
                    <!--<label>نبذة مختصرة:</label>-->
                    {!! Form::textarea('content', null, array('class' => 'form-control','rows' => '2')) !!}
                </div>
                <div class="form-group hidden">
                    <label> الفديوهات:</label>
                    {!! Form::select('videos[]', $videos,$postVideos, array('class' => 'select2-tags','multiple')) !!}
                </div>
                <div class="form-group">
                    <label>الكلمات البحث:</label>
                    {!! Form::select('tags[]', $tags,$postTags, array('class' => 'select2-tags','multiple')) !!}
                </div>
                @if($new == 0 )
                @if($post_active > 0)
                <!--                <div class="form-group">
                                    <label>التعليقات:</label>
                                    {!! Form::select('is_comment',statusType() ,null, array('class' => 'select2')) !!}
                                </div>-->
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
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
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="box">
            <div class="box-body">
                @if($image == 1)
                <div class="form-group">

                    <label>صورة :</label>
                    @if($type=='banner')<label class="padding-30"> حجم(1600*800) </label> @endif
                    <br>
                    <input id="image" name="image" type="hidden" value="{{ $image_link }}">
                    <img  src="{{ $image_link }}"  width="40%" height="auto" @if($image_link == Null)  style="display:none;" @endif />
                    @if($post_active == 1)
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>

                </div>
                @endif
                <!--                <div class="form-group">
                                    <label>الوصف التفصيلى :</label>
                                    ,'id'=>'my-textarea'
                                    {!! Form::textarea('description', null, array('class' => 'form-control','rows' => '3')) !!}
                                </div>-->
                @if (isset($postCategories[5])&&$postCategories[5] == 5)
                <div class="allow_latest">
                    @else
                    <div class="allow_latest hide">
                        @endif
                        <div class="form-group">
                            <label>تاريخ العرض:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <!--'id'=>'datepicker'-->
                                {!! Form::text('data', null, array('class' => 'form-control pull-right','id'=>'reservation')) !!}
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->

                    </div>  
                    @if (isset($postCategories[4])&&$postCategories[4] == 4)
                    <div class="allow_company">
                        @else
                        <div class="allow_company hide">
                            @endif
                            <div class="form-group">
                                <label>عنوان الشركة:</label>
                                {!! Form::text('address', $address, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <label>تلفون الشركة:</label>
                                {!! Form::text('phone', $phone, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <label>ايميل الشركة:</label>
                                {!! Form::text('email', $email, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        @if ((isset($postCategories[4])&&$postCategories[4] == 4)||(isset($postCategories[1])&&$postCategories[1] == 1))
                        <div class="allow_appoint">
                            @else
                            <div class="allow_appoint hide">
                                @endif
                                <label>مواعيد العمل:</label>
                                @include('admin.posts.posts.appoint')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
