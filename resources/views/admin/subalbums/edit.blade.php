@extends('admin.layouts.app')
@section('title') تعديل صورة الالبوم 
@stop
@section('head_content')
@include('admin.subalbums.head')
@stop
@section('content')
@include('admin.errors.errors')
@include('admin.errors.alerts')
{!! Form::model($album, ['method' => 'PATCH','route' => ['admin.subalbums.update', $album->id],'data-parsley-validate'=>""]) !!}
@include('admin.subalbums.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.subalbums.repeater')
@stop