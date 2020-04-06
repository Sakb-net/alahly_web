@extends('admin.layouts.app')
@section('title') تعديل الفديو 
@stop
@section('head_content')
@include('admin.videos.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($video, ['method' => 'PATCH','route' => ['admin.videos.update', $video->id],'data-parsley-validate'=>""]) !!}
@include('admin.videos.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.videos.repeater')
@stop