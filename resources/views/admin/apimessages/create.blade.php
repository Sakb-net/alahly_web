@extends('admin.layouts.app')
@section('title') اضافة  جديد 
@stop
@section('head_content')
@include('admin.apimessages.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.apimessages.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.apimessages.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.apimessages.repeater')
@stop