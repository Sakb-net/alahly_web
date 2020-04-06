@extends('admin.layouts.app')
@section('title') اضافة الفديو جديد 
@stop
@section('head_content')
@include('admin.videos.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.videos.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.videos.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.videos.repeater')
@stop