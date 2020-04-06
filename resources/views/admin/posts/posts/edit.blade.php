@extends('admin.layouts.app')
@section('title') تعديل  
@stop
@section('head_content')
@include('admin.posts.posts.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($post, ['method' => 'PATCH','route' => ['admin.posts.update', $post->id],'data-parsley-validate'=>""]) !!}
@include('admin.posts.posts.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.posts.posts.repeater')
@stop