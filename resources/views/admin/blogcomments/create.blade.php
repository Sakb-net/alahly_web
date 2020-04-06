@extends('admin.layouts.app')
@section('title') {{trans('app.add')}}{{trans('app.comment')}}  
@stop
@section('head_content')
@include('admin.blogcomments.head')
@stop
@section('content')

@include('admin.errors.errors')
@if(isset($blog->id))
{!! Form::open(array('route' => ['admin.blogs.comments.store', $blog->id],'method'=>'POST','data-parsley-validate'=>"")) !!}
@include('admin.blogcomments.form_create')
@else
{!! Form::open(array('route' => 'admin.blogcomments.store','method'=>'POST','data-parsley-validate'=>"")) !!}
@include('admin.blogcomments.form')
@endif
{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.blogcomments.repeater')
@stop