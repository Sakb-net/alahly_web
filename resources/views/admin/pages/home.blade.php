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
                <div class="form-group">
                <h5>صورة الخلفية   :  <label class="padding-30"> حجم(1600*200) </label></h5>
                    <br>
                    <input id="image" name="image_back" type="hidden" value="{{ $image_link }}">
                    <img  src="{{ $image_link }}"  width="40%" height="auto" @if($image_link == Null)  style="display:none;" @endif />
                    @if($post_active == 1)
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
                
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
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

