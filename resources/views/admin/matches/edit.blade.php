@extends('admin.layouts.app')
@section('title') تعديل  
@stop
@section('head_content')
@include('admin.matches.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($match, ['method' => 'PATCH','route' => ['admin.matches.update', $match->id],'data-parsley-validate'=>""]) !!}
@include('admin.matches.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.matches.repeater')
@stop