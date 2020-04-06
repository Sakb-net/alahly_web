@extends('admin.layouts.app')
@section('title') اضافة عضو جديد 
@stop
@section('head_content')
@include('admin.users.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.users.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.users.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.users.repeater')

@stop
