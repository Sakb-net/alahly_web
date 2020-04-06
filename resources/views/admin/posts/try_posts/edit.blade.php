@extends('admin.layouts.app')
@section('title') تعديل المشاركة 
@stop
@section('head_content')
@include('admin.posts.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($post, ['method' => 'PATCH','route' => ['admin.posts.update', $post->id],'data-parsley-validate'=>""]) !!}
@include('admin.posts.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@stop