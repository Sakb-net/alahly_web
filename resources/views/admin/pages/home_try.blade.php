@extends('admin.layouts.app')
@section('title') الرئيسية@stop
@section('content')

@include('admin.errors.errors')
@include('admin.errors.alerts')

{!! Form::open(array('route' => 'admin.pages.home.store','method'=>'POST','data-parsley-validate'=>"")) !!}

<div class="row">
    <div class="col-sm-7 col-lg-7 col-md-7">
        <div class="box">
            <div class="box-body">
                <h5>شريط الاخبار  : </h5>
                <div class="clearfix m-b"></div>
                <div class="raw title-repeater">
                    <div  data-repeater-list="titleHome" >
                        @if(count($all_title)!=0)
                        @foreach ($all_title as $key => $title)
                        <div  data-repeater-item>
                            <div class="col-sm-11">    
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <label>محتوى الرسالة</label>
                                    </div>
                                    <div class="col-sm-8">
                                        {!! Form::text('name', $title->option_value, array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <input type="hidden" name="title_id" value="{{$title->id}}" class="form-control m-b" >
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

                <div class="clearfix"></div>
                <div class="col-md-3 col-sm-4">
                    <input  type="button" class="btn btn-success btn-s-xs title-add-show" value="اضافة  نص"/>
                </div>
                <div class="clearfix"></div>
                <div class="raw title-add-repeater hide">
                    <div  data-repeater-list="title_addHome" >
                        <div  data-repeater-item>

                            <div class="col-sm-11"> 
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <label>محتوى الرسالة</label>
                                    </div>
                                    <div class="col-sm-8">
                                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
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
                        <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  نص"/>
                    </div>
                </div>

                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5 col-lg-5 col-md-5">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                <h5>صورة بنر الاسم  :  <label class="padding-30"> حجم(1600*200) </label></h5>
                    
                    <br>
                    <input id="image" name="image_banner" type="hidden" value="{{ $image_link }}">
                    <img  src="{{ $image_link }}"  width="40%" height="auto" @if($image_link == Null)  style="display:none;" @endif />
                    @if($post_active == 1)
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
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.pages.repeater')
@stop

