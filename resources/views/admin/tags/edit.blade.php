@extends('admin.layouts.app')
@section('title') تعديل الوسم 
@stop
@section('head_content')
@include('admin.tags.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($tag, ['method' => 'PATCH','route' => ['admin.tags.update', $tag->id],'data-parsley-validate'=>""]) !!}
@include('admin.tags.form')
{!! Form::close() !!}
@stop