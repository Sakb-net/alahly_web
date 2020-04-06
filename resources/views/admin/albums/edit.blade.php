@extends('admin.layouts.app')
@section('title') تعديل البوم 
@stop
@section('head_content')
@include('admin.albums.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($album, ['method' => 'PATCH','route' => ['admin.albums.update', $album->id],'data-parsley-validate'=>""]) !!}
@include('admin.albums.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.albums.repeater')
@stop