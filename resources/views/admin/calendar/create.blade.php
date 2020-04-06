@extends('admin.layouts.app')
@section('title') اضافة  جديد 
@stop
@section('head_content')
@include('admin.calendar.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.calendar.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.calendar.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.calendar.repeater')
@stop