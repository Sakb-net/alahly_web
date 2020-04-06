@extends('admin.layouts.app')
@section('title') {{trans('app.update')}}  {{trans('app.new_one')}}  
@stop
@section('head_content')
@include('admin.blogs.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($blog, ['method' => 'PATCH','route' => ['admin.blogs.update', $blog->id],'data-parsley-validate'=>""]) !!}
@include('admin.blogs.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.blogs.repeater')
@stop