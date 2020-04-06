@extends('admin.layouts.app')
@section('title') {{trans('app.add')}}{{trans('app.comment')}}  
@stop
@section('head_content')
@include('admin.videocomments.head')
@stop
@section('content')

@include('admin.errors.errors')
@if(isset($video->id))
{!! Form::open(array('route' => ['admin.videos.comments.store', $video->id],'method'=>'POST','data-parsley-validate'=>"")) !!}
@include('admin.videocomments.form_create')
@else
{!! Form::open(array('route' => 'admin.videocomments.store','method'=>'POST','data-parsley-validate'=>"")) !!}
@include('admin.videocomments.form')
@endif
{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.videocomments.repeater')
@stop