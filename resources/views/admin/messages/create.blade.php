@extends('admin.layouts.app')
@section('title') اضافة رسالة جديدة 
@stop
@section('head_content')
@include('admin.messages.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.messages.store','method'=>'post','data-parsley-validate'=>"")) !!}

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">

                <div class="form-group">

                    <label>اسم العضو:</label>

                    {!! Form::select('user_id',$user ,null, array('class' => 'select2','required'=>'')) !!}

                </div>
              

                <div class="form-group">

                    <label>الرسالة:</label>

                    {!! Form::textarea('message', null, array('placeholder' => 'message','class' => 'form-control','required'=>'')) !!}
                </div>
                
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

@stop
