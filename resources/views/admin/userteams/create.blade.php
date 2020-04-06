@extends('admin.layouts.app')
@section('title') اضافة لاعب جديد  
@stop
@section('head_content')
@include('admin.userteams.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.userclubteams.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.userteams.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.userteams.repeater')
@stop