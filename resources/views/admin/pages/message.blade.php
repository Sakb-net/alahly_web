@extends('admin.layouts.app')
@section('title') رسلتنا@stop
@section('content')
@include('admin.errors.errors')
@include('admin.errors.alerts')
{!! Form::open(array('route' => 'admin.pages.message.store','method'=>'POST','data-parsley-validate'=>"")) !!}
<div class="row">
    <div class="col-sm-8 col-xs-8 col-lg-8">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>اسم الصفحة:</label>
                    {!! Form::text('message_page', $message_page, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>العنوان فى الصفحة:</label>
                    {!! Form::text('message_title', $message_title, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>المحتوى فى الصفحة:</label>
                    {!! Form::textarea('message_content', $message_content, array('class' => 'form-control','id'=>'my-textarea')) !!}
                </div>
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>الصورة:</label>
                    <input id="icon_image" name="message_image" type="hidden" value="{{ $message_image }}">
                    <img  src="{{ $message_image }}"  width="60%" height="auto" @if($message_image == Null)  style="display:none;" @endif />
                          @if(Auth::user()->can('access-all', 'user-all'))
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=icon_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=icon_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
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
