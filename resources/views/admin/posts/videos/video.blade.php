@extends('admin.layouts.app')
@section('title') فديوهات Post
@stop
@section('head_content')
@include('admin.posts.videos.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($post, ['method' => 'PATCH','route' => ['admin.videos.update', $post->id],'data-parsley-validate'=>""]) !!}
@include('admin.posts.videos.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.posts.videos.repeater')
@stop