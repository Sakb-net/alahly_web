@extends('admin.layouts.app')
@section('title') {{trans('app.add')}}  {{trans('app.new_one')}}  {{trans('app.new')}}  
@stop
@section('head_content')
@include('admin.blogs.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::open(array('route' => 'admin.blogs.store','method'=>'post','data-parsley-validate'=>"")) !!}
@include('admin.blogs.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.blogs.repeater')
@stop