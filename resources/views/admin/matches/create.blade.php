@extends('admin.layouts.app')
@section('title') اضافة  جديدة 
@stop
@section('head_content')
@include('admin.matches.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::open(array('route' => 'admin.matches.store','method'=>'post','data-parsley-validate'=>"")) !!}

@include('admin.matches.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.matches.repeater')
@stop