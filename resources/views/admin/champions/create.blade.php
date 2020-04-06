@extends('admin.layouts.app')
@section('title') اضافة بطولة جديد 
@stop
@section('head_content')
@include('admin.champions.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.champions.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.champions.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.champions.repeater')
@stop