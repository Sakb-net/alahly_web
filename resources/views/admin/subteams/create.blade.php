@extends('admin.layouts.app')
@section('title') اضافة فريق جديد فرعى 
@stop
@section('head_content')
@include('admin.subteams.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.subclubteams.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.subteams.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.subteams.repeater')
@stop