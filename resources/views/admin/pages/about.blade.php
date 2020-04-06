@extends('admin.layouts.app')
@section('title') عن النادي@stop
@section('content')
@include('admin.errors.errors')
@include('admin.errors.alerts')
{!! Form::open(array('route' => 'admin.pages.about.store','method'=>'POST','data-parsley-validate'=>"")) !!}
<div class="row">
    <div class="col-sm-12 col-md-7 col-lg-7">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>اسم الصفحة:</label>
                    {!! Form::text('about_page', $about_page, array('class' => 'form-control','required'=>'')) !!}
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>العنوان الفكرة الاولى:</label>
                    {!! Form::text('about_title', $about_title, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>المحتوى الفكرة الاولى:</label>
                    <!--,'id'=>'my-textarea'-->
                    {!! Form::textarea('about_content', $about_content, array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>العنوان الفكرة الثانية:</label>
                    {!! Form::text('about_title_two', $about_title_two, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label>المحتوى الفكرة الثانية:</label>
                    <!--,'id'=>'my-textarea'-->
                    {!! Form::textarea('about_content_two', $about_content_two, array('class' => 'form-control')) !!}
                </div>
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>الصورة:</label>
                    <input id="icon_image" name="about_image" type="hidden" value="{{ $about_image }}">
                    <img  src="{{ $about_image }}"  width="60%" height="auto" @if($about_image == Null)  style="display:none;" @endif />
                          @if(Auth::user()->can('access-all', 'user-all'))
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=icon_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=icon_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>

                </div>
            </div>
        </div>
        <!--repeater-->
        @include('admin.pages.list_repeater')
        <!--Endrepeater-->
    </div>
</div>
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.pages.repeater')
@stop
