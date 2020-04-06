@extends('admin.layouts.app')
@section('title') {{trans('app.add')}}  {{trans('app.replay')}} 
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-success fa fa-comments" href="{{ route('admin.comments.show',[$id]) }}"></a>
        </div>
    </div>
</div>
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::open(array('route' => ['admin.comments.reply.store',$id],'method'=>'post','data-parsley-validate'=>"")) !!}
<div class="row">
    <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>{{trans('app.comments')}}  / {{trans('app.questions')}} :</label>
                    {!! Form::textarea('content', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                @if($comment_active > 0)
                @if($new == 0)
                <div class="form-group">
                    <label>{{trans('app.state')}} :</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2')) !!}
                </div>
                @endif
                @endif
                <div class="box-footer text-center">
                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-info padding-40" >{{trans('app.save')}} </button>
                       <a href="{{$link_return}}" class="btn btn-primary padding-30">{{trans('app.back')}} </a>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop
