@extends('admin.layouts.app')
@section('title') اضافة تعليق جديدة 
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-success fa fa-comments" href="{{ route('admin.posts.comments.index',[$id]) }}"></a>
        </div>
    </div>
</div>
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::open(array('route' => ['admin.posts.comments.store',$id],'method'=>'post','data-parsley-validate'=>"")) !!}
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>التعليق:</label>
                    {!! Form::textarea('content', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                @if($comment_active > 0)
                <div class="form-group">
                    <label>الكاتب:</label>
                    {!! Form::select('user_id',$users ,$user_id, array('class' => 'select2')) !!}
                </div>
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2')) !!}
                </div>
                @endif
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop
