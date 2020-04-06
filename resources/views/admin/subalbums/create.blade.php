@extends('admin.layouts.app')
@section('title') اضافةصورة للالبوم 
@stop
@section('head_content')
@include('admin.subalbums.head')
@stop
@section('content')

@include('admin.errors.errors')
@include('admin.errors.alerts')
{!! Form::open(array('route' => 'admin.subalbums.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.subalbums.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.subalbums.repeater')
@stop